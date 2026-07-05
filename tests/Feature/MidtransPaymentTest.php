<?php

use App\Models\DetailPemesanan;
use App\Models\Pembayaran;
use App\Models\Pemesanan;
use App\Models\Souvenir;
use App\Models\User;
use App\Services\MidtransPaymentService;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(DatabaseSeeder::class);
    $this->user = User::where('role', 'user')->first();
    $this->souvenir = Souvenir::where('status', 'Tersedia')->where('stok', '>', 0)->first();

    config([
        'midtrans.server_key' => 'SB-Mid-server-test',
        'midtrans.client_key' => 'SB-Mid-client-test',
        'midtrans.is_production' => false,
    ]);
});

function createSouvenirPemesananForMidtransTest(User $user, Souvenir $souvenir, int $quantity = 2): Pemesanan
{
    $pemesanan = Pemesanan::create([
        'user_id' => $user->user_id,
        'jenis_pemesanan' => Pemesanan::JENIS_SOUVENIR,
        'total_harga' => ($souvenir->harga * $quantity) + 5000,
        'status_pemesanan' => Pemesanan::STATUS_MENUNGGU_PEMBAYARAN,
    ]);

    DetailPemesanan::create([
        'pemesanan_id' => $pemesanan->pemesanan_id,
        'souvenir_id' => $souvenir->souvenir_id,
        'nama_item' => $souvenir->nama_souvenir,
        'harga' => $souvenir->harga,
        'jumlah' => $quantity,
        'subtotal' => $souvenir->harga * $quantity,
    ]);

    return $pemesanan;
}

function createMidtransPaymentForTest(Pemesanan $pemesanan): Pembayaran
{
    return Pembayaran::create([
        'pemesanan_id' => $pemesanan->pemesanan_id,
        'metode_pembayaran' => 'midtrans',
        'jumlah_bayar' => $pemesanan->total_harga,
        'status_pembayaran' => Pembayaran::STATUS_MENUNGGU_PEMBAYARAN,
        'tanggal_pembayaran' => now(),
        'midtrans_order_id' => 'MT-'.$pemesanan->kode_pemesanan.'-TEST',
        'midtrans_snap_token' => 'snap-token-test',
    ]);
}

function signedMidtransPayloadForTest(array $payload): array
{
    $payload['signature_key'] = hash(
        'sha512',
        $payload['order_id'].$payload['status_code'].$payload['gross_amount'].config('midtrans.server_key')
    );

    return $payload;
}

test('user can create midtrans snap token for own unpaid order', function () {
    $pemesanan = createSouvenirPemesananForMidtransTest($this->user, $this->souvenir);
    $midtransService = Mockery::mock(MidtransPaymentService::class);
    $midtransService->shouldReceive('createSnapToken')
        ->once()
        ->andReturn('snap-token-test');
    $this->app->instance(MidtransPaymentService::class, $midtransService);

    $response = $this->actingAs($this->user)
        ->postJson(route('user.pembayaran.midtrans.token', $pemesanan->pemesanan_id));

    $response->assertOk()
        ->assertJsonPath('snap_token', 'snap-token-test')
        ->assertJsonPath('client_key', 'SB-Mid-client-test');

    $pembayaran = Pembayaran::first();

    expect($pembayaran->pemesanan_id)->toBe($pemesanan->pemesanan_id);
    expect($pembayaran->metode_pembayaran)->toBe('midtrans');
    expect($pembayaran->status_pembayaran)->toBe(Pembayaran::STATUS_MENUNGGU_PEMBAYARAN);
    expect($pembayaran->midtrans_order_id)->not->toBeNull();
    expect($pembayaran->midtrans_snap_token)->toBe('snap-token-test');
});

test('midtrans token requires sandbox keys', function () {
    config([
        'midtrans.server_key' => null,
        'midtrans.client_key' => null,
    ]);
    $pemesanan = createSouvenirPemesananForMidtransTest($this->user, $this->souvenir);

    $this->actingAs($this->user)
        ->postJson(route('user.pembayaran.midtrans.token', $pemesanan->pemesanan_id))
        ->assertStatus(503)
        ->assertJsonPath('message', 'Konfigurasi Midtrans Sandbox belum lengkap. Isi MIDTRANS_SERVER_KEY dan MIDTRANS_CLIENT_KEY di .env.');

    expect(Pembayaran::count())->toBe(0);
});

test('midtrans token accepts sandbox dashboard keys without sb prefix', function () {
    config([
        'midtrans.server_key' => 'Mid-server-dashboard-test',
        'midtrans.client_key' => 'Mid-client-dashboard-test',
        'midtrans.is_production' => false,
    ]);
    $pemesanan = createSouvenirPemesananForMidtransTest($this->user, $this->souvenir);
    $midtransService = Mockery::mock(MidtransPaymentService::class);
    $midtransService->shouldReceive('createSnapToken')
        ->once()
        ->andReturn('snap-token-test');
    $this->app->instance(MidtransPaymentService::class, $midtransService);

    $this->actingAs($this->user)
        ->postJson(route('user.pembayaran.midtrans.token', $pemesanan->pemesanan_id))
        ->assertOk()
        ->assertJsonPath('snap_token', 'snap-token-test');

    expect(Pembayaran::count())->toBe(1);
});

test('midtrans token returns readable message when gateway rejects the key', function () {
    $pemesanan = createSouvenirPemesananForMidtransTest($this->user, $this->souvenir);
    $midtransService = Mockery::mock(MidtransPaymentService::class);
    $midtransService->shouldReceive('createSnapToken')
        ->once()
        ->andThrow(new RuntimeException('Gagal membuat transaksi Midtrans: HTTP status code: 401'));
    $this->app->instance(MidtransPaymentService::class, $midtransService);

    $this->actingAs($this->user)
        ->postJson(route('user.pembayaran.midtrans.token', $pemesanan->pemesanan_id))
        ->assertStatus(503)
        ->assertJsonPath('message', 'Gagal membuat transaksi Midtrans: HTTP status code: 401');
});

test('midtrans settlement verifies payment and updates stock once', function () {
    $pemesanan = createSouvenirPemesananForMidtransTest($this->user, $this->souvenir, 2);
    $pembayaran = createMidtransPaymentForTest($pemesanan);
    $initialStock = $this->souvenir->stok;
    $initialSold = $this->souvenir->jumlah_terjual;
    $payload = signedMidtransPayloadForTest([
        'order_id' => $pembayaran->midtrans_order_id,
        'status_code' => '200',
        'gross_amount' => number_format((float) $pemesanan->total_harga, 2, '.', ''),
        'transaction_status' => 'settlement',
        'transaction_id' => 'trx-midtrans-1',
        'payment_type' => 'bank_transfer',
        'va_numbers' => [
            ['bank' => 'bca', 'va_number' => '1234567890'],
        ],
    ]);

    $this->postJson(route('midtrans.notification'), $payload)->assertOk();
    $this->postJson(route('midtrans.notification'), $payload)->assertOk();

    expect($pembayaran->fresh()->status_pembayaran)->toBe(Pembayaran::STATUS_TERVERIFIKASI);
    expect($pembayaran->fresh()->midtrans_transaction_status)->toBe('settlement');
    expect($pembayaran->fresh()->midtrans_va_number)->toBe('1234567890');
    expect($pemesanan->fresh()->status_pemesanan)->toBe(Pemesanan::STATUS_DIPROSES);
    expect($this->souvenir->fresh()->stok)->toBe($initialStock - 2);
    expect($this->souvenir->fresh()->jumlah_terjual)->toBe($initialSold + 2);
});

test('user can refresh midtrans status when webhook is unavailable', function () {
    $pemesanan = createSouvenirPemesananForMidtransTest($this->user, $this->souvenir, 2);
    $pembayaran = createMidtransPaymentForTest($pemesanan);
    $initialStock = $this->souvenir->stok;
    $initialSold = $this->souvenir->jumlah_terjual;
    $midtransService = Mockery::mock(MidtransPaymentService::class);
    $midtransService->shouldReceive('checkTransactionStatus')
        ->once()
        ->andReturn([
            'order_id' => $pembayaran->midtrans_order_id,
            'status_code' => '200',
            'gross_amount' => number_format((float) $pemesanan->total_harga, 2, '.', ''),
            'transaction_status' => 'settlement',
            'transaction_id' => 'trx-midtrans-status-check',
            'payment_type' => 'bank_transfer',
            'va_numbers' => [
                ['bank' => 'bca', 'va_number' => '9876543210'],
            ],
        ]);
    $this->app->instance(MidtransPaymentService::class, $midtransService);

    $this->actingAs($this->user)
        ->postJson(route('user.pembayaran.midtrans.status', $pemesanan->pemesanan_id))
        ->assertOk()
        ->assertJsonPath('pembayaran_status', Pembayaran::STATUS_TERVERIFIKASI)
        ->assertJsonPath('pemesanan_status', Pemesanan::STATUS_DIPROSES)
        ->assertJsonPath('midtrans_status', 'settlement');

    expect($pembayaran->fresh()->midtrans_transaction_id)->toBe('trx-midtrans-status-check');
    expect($pembayaran->fresh()->midtrans_va_number)->toBe('9876543210');
    expect($this->souvenir->fresh()->stok)->toBe($initialStock - 2);
    expect($this->souvenir->fresh()->jumlah_terjual)->toBe($initialSold + 2);
});

test('midtrans webhook rejects invalid signature', function () {
    $pemesanan = createSouvenirPemesananForMidtransTest($this->user, $this->souvenir, 2);
    $pembayaran = createMidtransPaymentForTest($pemesanan);

    $this->postJson(route('midtrans.notification'), [
        'order_id' => $pembayaran->midtrans_order_id,
        'status_code' => '200',
        'gross_amount' => number_format((float) $pemesanan->total_harga, 2, '.', ''),
        'transaction_status' => 'settlement',
        'signature_key' => 'invalid-signature',
    ])->assertForbidden();

    expect($pembayaran->fresh()->status_pembayaran)->toBe(Pembayaran::STATUS_MENUNGGU_PEMBAYARAN);
});

test('midtrans failed payment does not update stock', function () {
    $pemesanan = createSouvenirPemesananForMidtransTest($this->user, $this->souvenir, 2);
    $pembayaran = createMidtransPaymentForTest($pemesanan);
    $initialStock = $this->souvenir->stok;
    $payload = signedMidtransPayloadForTest([
        'order_id' => $pembayaran->midtrans_order_id,
        'status_code' => '202',
        'gross_amount' => number_format((float) $pemesanan->total_harga, 2, '.', ''),
        'transaction_status' => 'expire',
        'transaction_id' => 'trx-midtrans-expired',
        'payment_type' => 'bank_transfer',
    ]);

    $this->postJson(route('midtrans.notification'), $payload)->assertOk();

    expect($pembayaran->fresh()->status_pembayaran)->toBe(Pembayaran::STATUS_DITOLAK);
    expect($pembayaran->fresh()->catatan_admin)->toBe('Transaksi Midtrans expire.');
    expect($pemesanan->fresh()->status_pemesanan)->toBe(Pemesanan::STATUS_MENUNGGU_PEMBAYARAN);
    expect($this->souvenir->fresh()->stok)->toBe($initialStock);
});
