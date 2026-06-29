<?php

use App\Models\DetailPemesanan;
use App\Models\Homestay;
use App\Models\KategoriHomestay;
use App\Models\Pembayaran;
use App\Models\Pemesanan;
use App\Models\Souvenir;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->admin = User::create([
        'nama' => 'Admin Laporan',
        'email' => 'admin.laporan@example.com',
        'password' => bcrypt('password'),
        'no_hp' => '081111111111',
        'alamat' => 'Padang',
        'role' => 'admin',
    ]);

    $this->user = User::create([
        'nama' => 'Pelanggan Laporan',
        'email' => 'pelanggan.laporan@example.com',
        'password' => bcrypt('password'),
        'no_hp' => '082222222222',
        'alamat' => 'Payakumbuh',
        'role' => 'user',
    ]);

    $this->kategori = KategoriHomestay::create([
        'nama_kategori' => 'Villa',
    ]);

    $this->homestay = Homestay::create([
        'kategori_id' => $this->kategori->kategori_id,
        'nama_homestay' => 'Natasha Garden House',
        'harga_permalam' => 350000,
        'kapasitas' => 4,
        'status' => 'Tersedia',
    ]);

    $this->souvenir = Souvenir::create([
        'nama_souvenir' => 'Miniatur Harau',
        'harga' => 50000,
        'stok' => 20,
        'status' => 'Tersedia',
        'updated_by' => $this->admin->user_id,
    ]);
});

function createReportSouvenirOrder(User $user, Souvenir $souvenir, string $paymentStatus, string $paymentDate, int $quantity = 2): Pemesanan
{
    $pemesanan = Pemesanan::create([
        'user_id' => $user->user_id,
        'jenis_pemesanan' => Pemesanan::JENIS_SOUVENIR,
        'tanggal_pemesanan' => $paymentDate,
        'total_harga' => $souvenir->harga * $quantity,
        'status_pemesanan' => Pemesanan::STATUS_DIPROSES,
    ]);

    DetailPemesanan::create([
        'pemesanan_id' => $pemesanan->pemesanan_id,
        'souvenir_id' => $souvenir->souvenir_id,
        'nama_item' => $souvenir->nama_souvenir,
        'harga' => $souvenir->harga,
        'jumlah' => $quantity,
        'subtotal' => $souvenir->harga * $quantity,
    ]);

    Pembayaran::create([
        'pemesanan_id' => $pemesanan->pemesanan_id,
        'metode_pembayaran' => 'transfer_bank',
        'jumlah_bayar' => $souvenir->harga * $quantity,
        'tanggal_pembayaran' => $paymentDate,
        'status_pembayaran' => $paymentStatus,
    ]);

    return $pemesanan;
}

function createReportHomestayOrder(User $user, Homestay $homestay, string $paymentStatus, string $paymentDate, string $reservationStatus = Pemesanan::STATUS_DIKONFIRMASI): Pemesanan
{
    $pemesanan = Pemesanan::create([
        'user_id' => $user->user_id,
        'jenis_pemesanan' => Pemesanan::JENIS_HOMESTAY,
        'tanggal_pemesanan' => $paymentDate,
        'total_harga' => $homestay->harga_permalam * 2,
        'status_pemesanan' => $reservationStatus,
    ]);

    DetailPemesanan::create([
        'pemesanan_id' => $pemesanan->pemesanan_id,
        'homestay_id' => $homestay->homestay_id,
        'nama_item' => $homestay->nama_homestay,
        'harga' => $homestay->harga_permalam,
        'jumlah' => 1,
        'check_in' => '2026-06-10',
        'check_out' => '2026-06-12',
        'jumlah_malam' => 2,
        'subtotal' => $homestay->harga_permalam * 2,
    ]);

    Pembayaran::create([
        'pemesanan_id' => $pemesanan->pemesanan_id,
        'metode_pembayaran' => 'transfer_bank',
        'jumlah_bayar' => $homestay->harga_permalam * 2,
        'tanggal_pembayaran' => $paymentDate,
        'status_pembayaran' => $paymentStatus,
    ]);

    return $pemesanan;
}

test('guest and normal user cannot access admin report', function () {
    $this->get(route('admin.laporan'))->assertRedirect(route('login'));

    $this->actingAs($this->user)
        ->get(route('admin.laporan'))
        ->assertRedirect(route('dashboard'));
});

test('admin can view report summary from verified payments', function () {
    createReportSouvenirOrder($this->user, $this->souvenir, Pembayaran::STATUS_TERVERIFIKASI, '2026-06-05 10:00:00', 2);
    createReportHomestayOrder($this->user, $this->homestay, Pembayaran::STATUS_TERVERIFIKASI, '2026-06-06 10:00:00');
    createReportSouvenirOrder($this->user, $this->souvenir, Pembayaran::STATUS_MENUNGGU_VERIFIKASI, '2026-06-07 10:00:00', 1);

    $response = $this->actingAs($this->admin)->get(route('admin.laporan', [
        'date_from' => '2026-06-01',
        'date_to' => '2026-06-30',
    ]));

    $response->assertStatus(200)
        ->assertSee('Laporan & Analitik', false)
        ->assertSee('Miniatur Harau')
        ->assertSee('Rp 800.000');

    $data = $response->original->getData();

    expect((float) $data['summary']['total_pendapatan'])->toBe(800000.0);
    expect((float) $data['summary']['pendapatan_souvenir'])->toBe(100000.0);
    expect((float) $data['summary']['pendapatan_homestay'])->toBe(700000.0);
    expect($data['summary']['transaksi_terverifikasi'])->toBe(2);
    expect($data['summary']['pembayaran_menunggu'])->toBe(1);
    expect($data['souvenirSales']->first()->total_terjual)->toBe(2);
    expect($data['reservationStatusCounts'][Pemesanan::STATUS_DIKONFIRMASI])->toBe(1);
});

test('admin report date filter excludes payments and reservations outside period', function () {
    createReportSouvenirOrder($this->user, $this->souvenir, Pembayaran::STATUS_TERVERIFIKASI, '2026-05-15 10:00:00', 3);
    createReportHomestayOrder($this->user, $this->homestay, Pembayaran::STATUS_TERVERIFIKASI, '2026-06-10 10:00:00', Pemesanan::STATUS_SELESAI);

    $response = $this->actingAs($this->admin)->get(route('admin.laporan', [
        'date_from' => '2026-06-01',
        'date_to' => '2026-06-30',
    ]));

    $data = $response->original->getData();

    expect((float) $data['summary']['total_pendapatan'])->toBe(700000.0);
    expect((float) $data['summary']['pendapatan_souvenir'])->toBe(0.0);
    expect($data['summary']['total_reservasi'])->toBe(1);
    expect($data['souvenirSales'])->toHaveCount(0);
    expect($data['reservationStatusCounts'][Pemesanan::STATUS_SELESAI])->toBe(1);
});

test('admin dashboard shows report metrics', function () {
    createReportSouvenirOrder($this->user, $this->souvenir, Pembayaran::STATUS_TERVERIFIKASI, now()->toDateTimeString(), 2);
    createReportHomestayOrder($this->user, $this->homestay, Pembayaran::STATUS_MENUNGGU_VERIFIKASI, now()->toDateTimeString(), Pemesanan::STATUS_MENUNGGU_VERIFIKASI);

    $this->actingAs($this->admin)
        ->get(route('admin.dashboard'))
        ->assertStatus(200)
        ->assertSee('Pendapatan Bulan Ini')
        ->assertSee('Rp 100.000')
        ->assertSee('Pembayaran Menunggu')
        ->assertSee('1');
});
