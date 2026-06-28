<?php

use App\Models\DetailPemesanan;
use App\Models\Homestay;
use App\Models\Pembayaran;
use App\Models\Pemesanan;
use App\Models\Souvenir;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(DatabaseSeeder::class);
    $this->user = User::where('role', 'user')->first();
    $this->admin = User::where('role', 'admin')->first();
    $this->souvenir = Souvenir::where('status', 'Tersedia')->where('stok', '>', 0)->first();
});

function createSouvenirPemesananForPaymentTest(User $user, Souvenir $souvenir, int $quantity = 2): Pemesanan
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

function createHomestayPemesananForPaymentTest(User $user, Homestay $homestay): Pemesanan
{
    $pemesanan = Pemesanan::create([
        'user_id' => $user->user_id,
        'jenis_pemesanan' => Pemesanan::JENIS_HOMESTAY,
        'total_harga' => $homestay->harga_permalam * 2,
        'status_pemesanan' => Pemesanan::STATUS_MENUNGGU_PEMBAYARAN,
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

test('user can upload payment proof for own order', function () {
    Storage::fake('public');
    $pemesanan = createSouvenirPemesananForPaymentTest($this->user, $this->souvenir);

    $response = $this->actingAs($this->user)->post(route('user.pembayaran.store', $pemesanan->pemesanan_id), [
        'metode_pembayaran' => 'transfer_bank',
        'jumlah_bayar' => $pemesanan->total_harga,
        'bukti_pembayaran' => UploadedFile::fake()->image('bukti.jpg'),
    ]);

    $response->assertRedirect(route('user.pesanan.show', $pemesanan->pemesanan_id));
    $response->assertSessionHas('success');

    $pembayaran = Pembayaran::first();

    expect($pembayaran->pemesanan_id)->toBe($pemesanan->pemesanan_id);
    expect($pembayaran->status_pembayaran)->toBe(Pembayaran::STATUS_MENUNGGU_VERIFIKASI);
    expect($pemesanan->fresh()->status_pemesanan)->toBe(Pemesanan::STATUS_MENUNGGU_VERIFIKASI);
    Storage::disk('public')->assertExists($pembayaran->bukti_pembayaran);
});

test('user cannot upload payment for another users order', function () {
    Storage::fake('public');
    $pemesanan = createSouvenirPemesananForPaymentTest($this->user, $this->souvenir);
    $otherUser = User::create([
        'nama' => 'Customer Lain',
        'email' => 'customer-lain@example.com',
        'password' => 'password123',
        'no_hp' => '081111111111',
        'alamat' => 'Padang',
        'role' => 'user',
    ]);

    $this->actingAs($otherUser)->post(route('user.pembayaran.store', $pemesanan->pemesanan_id), [
        'metode_pembayaran' => 'transfer_bank',
        'jumlah_bayar' => $pemesanan->total_harga,
        'bukti_pembayaran' => UploadedFile::fake()->image('bukti.jpg'),
    ])->assertNotFound();

    expect(Pembayaran::count())->toBe(0);
});

test('admin can view payment list and detail', function () {
    Storage::fake('public');
    $pemesanan = createSouvenirPemesananForPaymentTest($this->user, $this->souvenir);
    $this->actingAs($this->user)->post(route('user.pembayaran.store', $pemesanan->pemesanan_id), [
        'metode_pembayaran' => 'transfer_bank',
        'jumlah_bayar' => $pemesanan->total_harga,
        'bukti_pembayaran' => UploadedFile::fake()->image('bukti.jpg'),
    ]);

    $pembayaran = Pembayaran::first();

    $this->actingAs($this->admin)
        ->get(route('admin.pembayaran'))
        ->assertStatus(200)
        ->assertSee($pemesanan->kode_pemesanan);

    $this->actingAs($this->admin)
        ->get(route('admin.pembayaran.show', $pembayaran->pembayaran_id))
        ->assertStatus(200)
        ->assertSee($pemesanan->kode_pemesanan)
        ->assertSee($this->souvenir->nama_souvenir);
});

test('admin can filter payments by order category', function () {
    $homestay = Homestay::where('status', 'Tersedia')->first();
    $souvenirPemesanan = createSouvenirPemesananForPaymentTest($this->user, $this->souvenir);
    $homestayPemesanan = createHomestayPemesananForPaymentTest($this->user, $homestay);

    Pembayaran::create([
        'pemesanan_id' => $souvenirPemesanan->pemesanan_id,
        'metode_pembayaran' => 'transfer_bank',
        'jumlah_bayar' => $souvenirPemesanan->total_harga,
        'status_pembayaran' => Pembayaran::STATUS_MENUNGGU_VERIFIKASI,
        'tanggal_pembayaran' => now(),
    ]);

    Pembayaran::create([
        'pemesanan_id' => $homestayPemesanan->pemesanan_id,
        'metode_pembayaran' => 'transfer_bank',
        'jumlah_bayar' => $homestayPemesanan->total_harga,
        'status_pembayaran' => Pembayaran::STATUS_MENUNGGU_VERIFIKASI,
        'tanggal_pembayaran' => now(),
    ]);

    $this->actingAs($this->admin)
        ->get(route('admin.pembayaran', ['kategori' => Pemesanan::JENIS_SOUVENIR]))
        ->assertStatus(200)
        ->assertSee($souvenirPemesanan->kode_pemesanan)
        ->assertDontSee($homestayPemesanan->kode_pemesanan);

    $this->actingAs($this->admin)
        ->get(route('admin.pembayaran', ['kategori' => Pemesanan::JENIS_HOMESTAY]))
        ->assertStatus(200)
        ->assertSee($homestayPemesanan->kode_pemesanan)
        ->assertDontSee($souvenirPemesanan->kode_pemesanan);
});

test('admin can filter payments by payment status', function () {
    $waitingPemesanan = createSouvenirPemesananForPaymentTest($this->user, $this->souvenir);
    $verifiedPemesanan = createSouvenirPemesananForPaymentTest($this->user, $this->souvenir);

    Pembayaran::create([
        'pemesanan_id' => $waitingPemesanan->pemesanan_id,
        'metode_pembayaran' => 'transfer_bank',
        'jumlah_bayar' => $waitingPemesanan->total_harga,
        'status_pembayaran' => Pembayaran::STATUS_MENUNGGU_VERIFIKASI,
        'tanggal_pembayaran' => now(),
    ]);

    Pembayaran::create([
        'pemesanan_id' => $verifiedPemesanan->pemesanan_id,
        'metode_pembayaran' => 'transfer_bank',
        'jumlah_bayar' => $verifiedPemesanan->total_harga,
        'status_pembayaran' => Pembayaran::STATUS_TERVERIFIKASI,
        'tanggal_pembayaran' => now(),
    ]);

    $this->actingAs($this->admin)
        ->get(route('admin.pembayaran', ['status' => Pembayaran::STATUS_TERVERIFIKASI]))
        ->assertStatus(200)
        ->assertSee($verifiedPemesanan->kode_pemesanan)
        ->assertDontSee($waitingPemesanan->kode_pemesanan);
});

test('admin can verify payment and update stock once', function () {
    Storage::fake('public');
    $pemesanan = createSouvenirPemesananForPaymentTest($this->user, $this->souvenir, 2);
    $initialStock = $this->souvenir->stok;
    $initialSold = $this->souvenir->jumlah_terjual;

    $this->actingAs($this->user)->post(route('user.pembayaran.store', $pemesanan->pemesanan_id), [
        'metode_pembayaran' => 'transfer_bank',
        'jumlah_bayar' => $pemesanan->total_harga,
        'bukti_pembayaran' => UploadedFile::fake()->image('bukti.jpg'),
    ]);

    $pembayaran = Pembayaran::first();

    $response = $this->actingAs($this->admin)
        ->post(route('admin.pembayaran.verify', $pembayaran->pembayaran_id));

    $response->assertRedirect(route('admin.pembayaran.show', $pembayaran->pembayaran_id));
    $response->assertSessionHas('success');

    expect($pembayaran->fresh()->status_pembayaran)->toBe(Pembayaran::STATUS_TERVERIFIKASI);
    expect($pemesanan->fresh()->status_pemesanan)->toBe(Pemesanan::STATUS_DIPROSES);
    expect($this->souvenir->fresh()->stok)->toBe($initialStock - 2);
    expect($this->souvenir->fresh()->jumlah_terjual)->toBe($initialSold + 2);
});

test('admin can reject payment without changing stock', function () {
    Storage::fake('public');
    $pemesanan = createSouvenirPemesananForPaymentTest($this->user, $this->souvenir, 2);
    $initialStock = $this->souvenir->stok;
    $initialSold = $this->souvenir->jumlah_terjual;

    $this->actingAs($this->user)->post(route('user.pembayaran.store', $pemesanan->pemesanan_id), [
        'metode_pembayaran' => 'transfer_bank',
        'jumlah_bayar' => $pemesanan->total_harga,
        'bukti_pembayaran' => UploadedFile::fake()->image('bukti.jpg'),
    ]);

    $pembayaran = Pembayaran::first();

    $this->actingAs($this->admin)->post(route('admin.pembayaran.reject', $pembayaran->pembayaran_id), [
        'catatan_admin' => 'Bukti pembayaran kurang jelas.',
    ])->assertSessionHas('success');

    expect($pembayaran->fresh()->status_pembayaran)->toBe(Pembayaran::STATUS_DITOLAK);
    expect($pemesanan->fresh()->status_pemesanan)->toBe(Pemesanan::STATUS_MENUNGGU_PEMBAYARAN);
    expect($this->souvenir->fresh()->stok)->toBe($initialStock);
    expect($this->souvenir->fresh()->jumlah_terjual)->toBe($initialSold);
});

test('duplicate verification does not reduce stock twice', function () {
    Storage::fake('public');
    $pemesanan = createSouvenirPemesananForPaymentTest($this->user, $this->souvenir, 2);
    $initialStock = $this->souvenir->stok;

    $this->actingAs($this->user)->post(route('user.pembayaran.store', $pemesanan->pemesanan_id), [
        'metode_pembayaran' => 'transfer_bank',
        'jumlah_bayar' => $pemesanan->total_harga,
        'bukti_pembayaran' => UploadedFile::fake()->image('bukti.jpg'),
    ]);

    $pembayaran = Pembayaran::first();

    $this->actingAs($this->admin)->post(route('admin.pembayaran.verify', $pembayaran->pembayaran_id));
    $this->actingAs($this->admin)
        ->post(route('admin.pembayaran.verify', $pembayaran->pembayaran_id))
        ->assertSessionHas('error');

    expect($this->souvenir->fresh()->stok)->toBe($initialStock - 2);
});
