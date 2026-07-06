<?php

use App\Models\DetailPemesanan;
use App\Models\Homestay;
use App\Models\Invoice;
use App\Models\Pembayaran;
use App\Models\Pemesanan;
use App\Models\Souvenir;
use App\Models\User;
use App\Services\PaymentSettlementService;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(DatabaseSeeder::class);
    $this->user = User::where('role', 'user')->first();
    $this->admin = User::where('role', 'admin')->first();
    $this->souvenir = Souvenir::where('status', 'Tersedia')->where('stok', '>', 0)->first();
    $this->homestay = Homestay::where('status', 'Tersedia')->first();
});

function createSouvenirPemesananForInvoiceTest(User $user, Souvenir $souvenir, int $quantity = 2): Pemesanan
{
    $pemesanan = Pemesanan::create([
        'user_id' => $user->user_id,
        'jenis_pemesanan' => Pemesanan::JENIS_SOUVENIR,
        'total_harga' => ($souvenir->harga * $quantity) + 5000,
        'status_pemesanan' => Pemesanan::STATUS_MENUNGGU_VERIFIKASI,
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

function createHomestayPemesananForInvoiceTest(User $user, Homestay $homestay): Pemesanan
{
    $pemesanan = Pemesanan::create([
        'user_id' => $user->user_id,
        'jenis_pemesanan' => Pemesanan::JENIS_HOMESTAY,
        'total_harga' => $homestay->harga_permalam * 2,
        'status_pemesanan' => Pemesanan::STATUS_MENUNGGU_VERIFIKASI,
    ]);

    DetailPemesanan::create([
        'pemesanan_id' => $pemesanan->pemesanan_id,
        'homestay_id' => $homestay->homestay_id,
        'nama_item' => $homestay->nama_homestay,
        'harga' => $homestay->harga_permalam,
        'jumlah' => 1,
        'check_in' => now()->addDay()->toDateString(),
        'check_out' => now()->addDays(3)->toDateString(),
        'jumlah_malam' => 2,
        'subtotal' => $homestay->harga_permalam * 2,
    ]);

    return $pemesanan;
}

function createPaymentForInvoiceTest(Pemesanan $pemesanan): Pembayaran
{
    return Pembayaran::create([
        'pemesanan_id' => $pemesanan->pemesanan_id,
        'metode_pembayaran' => 'transfer_bank',
        'jumlah_bayar' => $pemesanan->total_harga,
        'status_pembayaran' => Pembayaran::STATUS_MENUNGGU_VERIFIKASI,
        'tanggal_pembayaran' => now(),
    ]);
}

test('verified souvenir payment creates invoice visible to customer and admin', function () {
    $pemesanan = createSouvenirPemesananForInvoiceTest($this->user, $this->souvenir);
    $pembayaran = createPaymentForInvoiceTest($pemesanan);

    $this->actingAs($this->admin)
        ->post(route('admin.pembayaran.verify', $pembayaran->pembayaran_id))
        ->assertRedirect(route('admin.pembayaran.show', $pembayaran->pembayaran_id))
        ->assertSessionHas('success');

    $invoice = Invoice::first();

    expect($invoice)->not->toBeNull();
    expect($invoice->pemesanan_id)->toBe($pemesanan->pemesanan_id);
    expect($invoice->pembayaran_id)->toBe($pembayaran->pembayaran_id);
    expect((float) $invoice->total_tagihan)->toBe((float) $pemesanan->total_harga);
    expect($invoice->nomor_invoice)->toStartWith('INV-');

    $this->actingAs($this->user)
        ->get(route('user.pesanan.show', $pemesanan->pemesanan_id))
        ->assertStatus(200)
        ->assertSee('Lihat Invoice');

    $this->actingAs($this->user)
        ->get(route('user.invoices.show', $pemesanan->pemesanan_id))
        ->assertStatus(200)
        ->assertSee($invoice->nomor_invoice)
        ->assertSee($pemesanan->kode_pemesanan)
        ->assertSee($this->souvenir->nama_souvenir);

    $this->actingAs($this->admin)
        ->get(route('admin.pembayaran.show', $pembayaran->pembayaran_id))
        ->assertStatus(200)
        ->assertSee('Lihat Invoice');

    $this->actingAs($this->admin)
        ->get(route('admin.invoices.show', $invoice->invoice_id))
        ->assertStatus(200)
        ->assertSee($invoice->nomor_invoice)
        ->assertSee($this->user->nama);
});

test('duplicate verification does not create duplicate invoice', function () {
    $pemesanan = createSouvenirPemesananForInvoiceTest($this->user, $this->souvenir);
    $pembayaran = createPaymentForInvoiceTest($pemesanan);

    $this->actingAs($this->admin)->post(route('admin.pembayaran.verify', $pembayaran->pembayaran_id));
    $this->actingAs($this->admin)
        ->post(route('admin.pembayaran.verify', $pembayaran->pembayaran_id))
        ->assertSessionHas('error');

    expect(Invoice::count())->toBe(1);
});

test('customer cannot view another customers invoice', function () {
    $pemesanan = createSouvenirPemesananForInvoiceTest($this->user, $this->souvenir);
    $pembayaran = createPaymentForInvoiceTest($pemesanan);
    app(PaymentSettlementService::class)->verify($pembayaran, $this->admin->user_id);

    $otherUser = User::create([
        'nama' => 'Customer Lain',
        'email' => 'invoice-other@example.com',
        'password' => bcrypt('password'),
        'no_hp' => '081111111111',
        'alamat' => 'Padang',
        'role' => 'user',
    ]);

    $this->actingAs($otherUser)
        ->get(route('user.invoices.show', $pemesanan->pemesanan_id))
        ->assertNotFound();
});

test('verified homestay payment also creates printable invoice', function () {
    $pemesanan = createHomestayPemesananForInvoiceTest($this->user, $this->homestay);
    $pembayaran = createPaymentForInvoiceTest($pemesanan);

    app(PaymentSettlementService::class)->verify($pembayaran, $this->admin->user_id);

    $invoice = Invoice::first();

    expect($invoice)->not->toBeNull();
    expect($invoice->pemesanan_id)->toBe($pemesanan->pemesanan_id);

    $this->actingAs($this->user)
        ->get(route('user.invoices.show', $pemesanan->pemesanan_id))
        ->assertStatus(200)
        ->assertSee($invoice->nomor_invoice)
        ->assertSee($this->homestay->nama_homestay)
        ->assertSee('2 malam');

    $this->actingAs($this->admin)
        ->get(route('admin.invoices.show', $invoice->invoice_id))
        ->assertStatus(200)
        ->assertSee('homestay');
});

test('guest cannot access invoice pages', function () {
    $pemesanan = createSouvenirPemesananForInvoiceTest($this->user, $this->souvenir);
    $pembayaran = createPaymentForInvoiceTest($pemesanan);
    app(PaymentSettlementService::class)->verify($pembayaran, $this->admin->user_id);
    $invoice = Invoice::first();

    $this->get(route('user.invoices.show', $pemesanan->pemesanan_id))->assertRedirect(route('login'));
    $this->get(route('admin.invoices.show', $invoice->invoice_id))->assertRedirect(route('login'));
});
