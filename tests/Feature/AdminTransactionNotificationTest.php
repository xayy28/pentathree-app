<?php

use App\Models\DetailPemesanan;
use App\Models\Homestay;
use App\Models\KategoriHomestay;
use App\Models\Pembayaran;
use App\Models\Pemesanan;
use App\Models\Souvenir;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->admin = User::create([
        'nama' => 'Admin Natasha',
        'email' => 'admin.notifikasi@example.com',
        'password' => bcrypt('password'),
        'no_hp' => '081111111111',
        'alamat' => 'Bandung',
        'role' => 'admin',
    ]);

    $this->user = User::create([
        'nama' => 'Pelanggan Natasha',
        'email' => 'pelanggan.notifikasi@example.com',
        'password' => bcrypt('password'),
        'no_hp' => '082222222222',
        'alamat' => 'Garut',
        'role' => 'user',
    ]);

    $this->kategori = KategoriHomestay::create([
        'nama_kategori' => 'Villa',
        'deskripsi' => 'Homestay keluarga',
    ]);

    $this->homestay = Homestay::create([
        'kategori_id' => $this->kategori->kategori_id,
        'nama_homestay' => 'Natasha Garden House',
        'harga_permalam' => 350000,
        'kapasitas' => 4,
        'status' => 'Tersedia',
    ]);

    $this->souvenir = Souvenir::create([
        'nama_souvenir' => 'Gantungan Kunci Natasha',
        'deskripsi' => 'Souvenir kecil untuk pelanggan.',
        'harga' => 25000,
        'stok' => 10,
        'status' => 'Tersedia',
    ]);
});

function createHomestayNotificationOrder(User $user, Homestay $homestay, ?string $seenAt = null): Pemesanan
{
    $pemesanan = Pemesanan::create([
        'user_id' => $user->user_id,
        'jenis_pemesanan' => Pemesanan::JENIS_HOMESTAY,
        'total_harga' => $homestay->harga_permalam * 2,
        'status_pemesanan' => Pemesanan::STATUS_MENUNGGU_PEMBAYARAN,
        'admin_dilihat_pada' => $seenAt,
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

function createSouvenirNotificationOrder(User $user, Souvenir $souvenir, ?string $seenAt = null): Pemesanan
{
    $pemesanan = Pemesanan::create([
        'user_id' => $user->user_id,
        'jenis_pemesanan' => Pemesanan::JENIS_SOUVENIR,
        'total_harga' => ($souvenir->harga * 2) + 5000,
        'status_pemesanan' => Pemesanan::STATUS_MENUNGGU_VERIFIKASI,
        'admin_dilihat_pada' => $seenAt,
    ]);

    DetailPemesanan::create([
        'pemesanan_id' => $pemesanan->pemesanan_id,
        'souvenir_id' => $souvenir->souvenir_id,
        'nama_item' => $souvenir->nama_souvenir,
        'harga' => $souvenir->harga,
        'jumlah' => 2,
        'subtotal' => $souvenir->harga * 2,
    ]);

    return $pemesanan;
}

test('admin header shows unread transaction notification count', function () {
    $unread = createHomestayNotificationOrder($this->user, $this->homestay);
    $seen = createSouvenirNotificationOrder($this->user, $this->souvenir, now()->toDateTimeString());

    $this->actingAs($this->admin)
        ->get(route('admin.dashboard'))
        ->assertStatus(200)
        ->assertSee('Notifikasi Transaksi')
        ->assertSee('1 transaksi perlu dicek')
        ->assertSee(route('admin.notifikasi.transaksi', $unread->pemesanan_id), false)
        ->assertDontSee(route('admin.notifikasi.transaksi', $seen->pemesanan_id), false);
});

test('admin can open notification and mark homestay transaction as seen', function () {
    $pemesanan = createHomestayNotificationOrder($this->user, $this->homestay);

    $this->actingAs($this->admin)
        ->get(route('admin.notifikasi.transaksi', $pemesanan->pemesanan_id))
        ->assertRedirect(route('admin.reservasi.show', $pemesanan->pemesanan_id));

    expect($pemesanan->fresh()->admin_dilihat_pada)->not->toBeNull();
});

test('opening souvenir payment detail marks transaction as seen', function () {
    $pemesanan = createSouvenirNotificationOrder($this->user, $this->souvenir);
    $pembayaran = Pembayaran::create([
        'pemesanan_id' => $pemesanan->pemesanan_id,
        'metode_pembayaran' => 'transfer_bank',
        'jumlah_bayar' => $pemesanan->total_harga,
        'status_pembayaran' => Pembayaran::STATUS_MENUNGGU_VERIFIKASI,
        'tanggal_pembayaran' => now(),
    ]);

    $this->actingAs($this->admin)
        ->get(route('admin.pembayaran.show', $pembayaran->pembayaran_id))
        ->assertStatus(200)
        ->assertSee($pemesanan->kode_pemesanan);

    expect($pemesanan->fresh()->admin_dilihat_pada)->not->toBeNull();
});

test('payment waiting verification stays in notification until admin processes it', function () {
    $pemesanan = createSouvenirNotificationOrder($this->user, $this->souvenir, now()->toDateTimeString());
    Pembayaran::create([
        'pemesanan_id' => $pemesanan->pemesanan_id,
        'metode_pembayaran' => 'transfer_bank',
        'jumlah_bayar' => $pemesanan->total_harga,
        'status_pembayaran' => Pembayaran::STATUS_MENUNGGU_VERIFIKASI,
        'tanggal_pembayaran' => now(),
    ]);

    $this->actingAs($this->admin)
        ->get(route('admin.dashboard'))
        ->assertStatus(200)
        ->assertSee('1 transaksi perlu dicek')
        ->assertSee(route('admin.notifikasi.transaksi', $pemesanan->pemesanan_id), false)
        ->assertSee('Butuh Verifikasi');
});

test('manual payment upload resets admin notification after order was already seen', function () {
    Storage::fake('public');
    $pemesanan = createSouvenirNotificationOrder($this->user, $this->souvenir, now()->toDateTimeString());
    Pembayaran::create([
        'pemesanan_id' => $pemesanan->pemesanan_id,
        'metode_pembayaran' => 'transfer_bank',
        'jumlah_bayar' => $pemesanan->total_harga,
        'status_pembayaran' => Pembayaran::STATUS_DITOLAK,
        'tanggal_pembayaran' => now(),
    ]);

    $this->actingAs($this->user)
        ->post(route('user.pembayaran.store', $pemesanan->pemesanan_id), [
            'metode_pembayaran' => 'transfer_bank',
            'jumlah_bayar' => $pemesanan->total_harga,
            'bukti_pembayaran' => UploadedFile::fake()->image('bukti.jpg'),
        ])
        ->assertRedirect(route('user.pesanan.index'));

    expect($pemesanan->fresh()->admin_dilihat_pada)->toBeNull();

    $this->actingAs($this->admin)
        ->get(route('admin.dashboard'))
        ->assertStatus(200)
        ->assertSee('1 transaksi perlu dicek')
        ->assertSee(route('admin.notifikasi.transaksi', $pemesanan->pemesanan_id), false);
});