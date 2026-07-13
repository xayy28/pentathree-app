<?php

use App\Models\DetailPemesanan;
use App\Models\Homestay;
use App\Models\KategoriHomestay;
use App\Models\Pembayaran;
use App\Models\Pemesanan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->admin = User::create([
        'nama' => 'Admin Natasha',
        'email' => 'admin.reservasi@example.com',
        'password' => bcrypt('password'),
        'no_hp' => '081111111111',
        'alamat' => 'Bandung',
        'role' => 'admin',
        'email_verified_at' => now(),
    ]);

    $this->user = User::create([
        'nama' => 'Pelanggan Natasha',
        'email' => 'pelanggan.reservasi@example.com',
        'password' => bcrypt('password'),
        'no_hp' => '082222222222',
        'alamat' => 'Garut',
        'role' => 'user',
        'email_verified_at' => now(),
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
});

function createHomestayReservationForAdminTest(User $user, Homestay $homestay, string $status = Pemesanan::STATUS_MENUNGGU_PEMBAYARAN): Pemesanan
{
    $pemesanan = Pemesanan::create([
        'user_id' => $user->user_id,
        'jenis_pemesanan' => Pemesanan::JENIS_HOMESTAY,
        'total_harga' => $homestay->harga_permalam * 2,
        'status_pemesanan' => $status,
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

function createPaymentForAdminReservationTest(Pemesanan $reservasi, string $status = Pembayaran::STATUS_TERVERIFIKASI): Pembayaran
{
    return Pembayaran::create([
        'pemesanan_id' => $reservasi->pemesanan_id,
        'metode_pembayaran' => 'transfer_bank',
        'jumlah_bayar' => $reservasi->total_harga,
        'status_pembayaran' => $status,
        'tanggal_pembayaran' => now(),
    ]);
}
test('guest cannot access admin reservation pages', function () {
    $reservasi = createHomestayReservationForAdminTest($this->user, $this->homestay);

    $this->get(route('admin.reservasi'))->assertRedirect(route('login'));
    $this->get(route('admin.reservasi.show', $reservasi->pemesanan_id))->assertRedirect(route('login'));
    $this->post(route('admin.reservasi.status', $reservasi->pemesanan_id), [
        'status_pemesanan' => Pemesanan::STATUS_DIKONFIRMASI,
    ])->assertRedirect(route('login'));
});

test('normal user cannot access admin reservation pages', function () {
    $reservasi = createHomestayReservationForAdminTest($this->user, $this->homestay);

    $this->actingAs($this->user)->get(route('admin.reservasi'))->assertRedirect(route('dashboard'));
    $this->actingAs($this->user)->get(route('admin.reservasi.show', $reservasi->pemesanan_id))->assertRedirect(route('dashboard'));
    $this->actingAs($this->user)->post(route('admin.reservasi.status', $reservasi->pemesanan_id), [
        'status_pemesanan' => Pemesanan::STATUS_DIKONFIRMASI,
    ])->assertRedirect(route('dashboard'));
});

test('admin can view homestay reservation list and detail', function () {
    $reservasi = createHomestayReservationForAdminTest($this->user, $this->homestay);

    $this->actingAs($this->admin)
        ->get(route('admin.reservasi'))
        ->assertStatus(200)
        ->assertSee($reservasi->kode_pemesanan)
        ->assertSee('Natasha Garden House')
        ->assertSee('Pelanggan Natasha');

    $this->actingAs($this->admin)
        ->get(route('admin.reservasi.show', $reservasi->pemesanan_id))
        ->assertStatus(200)
        ->assertSee($reservasi->kode_pemesanan)
        ->assertSee('350.000');
});

test('admin can filter reservations by status', function () {
    $waitingReservation = createHomestayReservationForAdminTest($this->user, $this->homestay);
    $confirmedReservation = createHomestayReservationForAdminTest($this->user, $this->homestay, Pemesanan::STATUS_DIKONFIRMASI);

    $this->actingAs($this->admin)
        ->get(route('admin.reservasi', ['status' => Pemesanan::STATUS_DIKONFIRMASI]))
        ->assertStatus(200)
        ->assertSee($confirmedReservation->kode_pemesanan)
        ->assertDontSee($waitingReservation->kode_pemesanan);
});

test('admin can filter reservations by payment workflow statuses', function () {
    $waitingVerification = createHomestayReservationForAdminTest($this->user, $this->homestay, Pemesanan::STATUS_MENUNGGU_VERIFIKASI);
    $stayingReservation = createHomestayReservationForAdminTest($this->user, $this->homestay, Pemesanan::STATUS_SEDANG_MENGINAP);

    $this->actingAs($this->admin)
        ->get(route('admin.reservasi', ['status' => Pemesanan::STATUS_MENUNGGU_VERIFIKASI]))
        ->assertStatus(200)
        ->assertSee($waitingVerification->kode_pemesanan)
        ->assertDontSee($stayingReservation->kode_pemesanan);
});

test('admin can update reservation status after payment is verified', function () {
    $reservasi = createHomestayReservationForAdminTest($this->user, $this->homestay, Pemesanan::STATUS_DIKONFIRMASI);
    createPaymentForAdminReservationTest($reservasi);

    $this->actingAs($this->admin)
        ->post(route('admin.reservasi.status', $reservasi->pemesanan_id), [
            'status_pemesanan' => Pemesanan::STATUS_SEDANG_MENGINAP,
        ])
        ->assertRedirect(route('admin.reservasi.show', $reservasi->pemesanan_id));

    expect($reservasi->fresh()->status_pemesanan)->toBe(Pemesanan::STATUS_SEDANG_MENGINAP);

    $this->actingAs($this->admin)
        ->post(route('admin.reservasi.status', $reservasi->pemesanan_id), [
            'status_pemesanan' => Pemesanan::STATUS_SELESAI,
        ])
        ->assertRedirect(route('admin.reservasi.show', $reservasi->pemesanan_id));

    expect($reservasi->fresh()->status_pemesanan)->toBe(Pemesanan::STATUS_SELESAI);

    $this->actingAs($this->user)
        ->get(route('user.pesanan.show', $reservasi->pemesanan_id))
        ->assertStatus(200)
        ->assertSee('Selesai');
});

test('admin cannot confirm active reservation statuses before payment is verified', function () {
    $reservasi = createHomestayReservationForAdminTest($this->user, $this->homestay);

    $this->actingAs($this->admin)
        ->post(route('admin.reservasi.status', $reservasi->pemesanan_id), [
            'status_pemesanan' => Pemesanan::STATUS_DIKONFIRMASI,
        ])
        ->assertRedirect(route('admin.reservasi.show', $reservasi->pemesanan_id))
        ->assertSessionHas('error');

    expect($reservasi->fresh()->status_pemesanan)->toBe(Pemesanan::STATUS_MENUNGGU_PEMBAYARAN);
});

test('admin can verify homestay payment and confirm booking', function () {
    $reservasi = createHomestayReservationForAdminTest($this->user, $this->homestay, Pemesanan::STATUS_MENUNGGU_VERIFIKASI);
    $pembayaran = createPaymentForAdminReservationTest($reservasi, Pembayaran::STATUS_MENUNGGU_VERIFIKASI);

    $this->actingAs($this->admin)
        ->post(route('admin.reservasi.verify-payment', $reservasi->pemesanan_id))
        ->assertRedirect(route('admin.reservasi.show', $reservasi->pemesanan_id))
        ->assertSessionHas('success');

    expect($pembayaran->fresh()->status_pembayaran)->toBe(Pembayaran::STATUS_TERVERIFIKASI);
    expect($pembayaran->fresh()->verified_by)->toBe($this->admin->user_id);
    expect($reservasi->fresh()->status_pemesanan)->toBe(Pemesanan::STATUS_DIKONFIRMASI);

    $this->assertDatabaseHas('invoices', [
        'pemesanan_id' => $reservasi->pemesanan_id,
        'pembayaran_id' => $pembayaran->pembayaran_id,
    ]);
});

test('admin can reject homestay payment and return booking to waiting payment', function () {
    $reservasi = createHomestayReservationForAdminTest($this->user, $this->homestay, Pemesanan::STATUS_MENUNGGU_VERIFIKASI);
    $pembayaran = createPaymentForAdminReservationTest($reservasi, Pembayaran::STATUS_MENUNGGU_VERIFIKASI);

    $this->actingAs($this->admin)
        ->post(route('admin.reservasi.reject-payment', $reservasi->pemesanan_id), [
            'catatan_admin' => 'Bukti pembayaran kurang jelas.',
        ])
        ->assertRedirect(route('admin.reservasi.show', $reservasi->pemesanan_id))
        ->assertSessionHas('success');

    expect($pembayaran->fresh()->status_pembayaran)->toBe(Pembayaran::STATUS_DITOLAK);
    expect($pembayaran->fresh()->catatan_admin)->toBe('Bukti pembayaran kurang jelas.');
    expect($reservasi->fresh()->status_pemesanan)->toBe(Pemesanan::STATUS_MENUNGGU_PEMBAYARAN);
});

test('admin cannot delete homestay with active reservation', function () {
    createHomestayReservationForAdminTest($this->user, $this->homestay, Pemesanan::STATUS_DIKONFIRMASI);

    $this->actingAs($this->admin)
        ->delete(route('admin.homestay.destroy', $this->homestay->homestay_id))
        ->assertRedirect(route('admin.homestay'))
        ->assertSessionHas('error');

    $this->assertDatabaseHas('homestays', [
        'homestay_id' => $this->homestay->homestay_id,
    ]);
});

test('admin can delete homestay after reservation is finished', function () {
    createHomestayReservationForAdminTest($this->user, $this->homestay, Pemesanan::STATUS_SELESAI);

    $this->actingAs($this->admin)
        ->delete(route('admin.homestay.destroy', $this->homestay->homestay_id))
        ->assertRedirect(route('admin.homestay'))
        ->assertSessionHas('success');

    $this->assertSoftDeleted($this->homestay);
});
test('admin can delete homestay after reservation is expired', function () {
    createHomestayReservationForAdminTest($this->user, $this->homestay, Pemesanan::STATUS_KEDALUWARSA);

    $this->actingAs($this->admin)
        ->delete(route('admin.homestay.destroy', $this->homestay->homestay_id))
        ->assertRedirect(route('admin.homestay'))
        ->assertSessionHas('success');

    $this->assertSoftDeleted($this->homestay);
});
test('admin can view homestay availability calendar', function () {
    createHomestayReservationForAdminTest($this->user, $this->homestay, Pemesanan::STATUS_DIKONFIRMASI);

    $this->actingAs($this->admin)
        ->get(route('admin.homestay', ['availability_month' => now()->format('Y-m')]))
        ->assertStatus(200)
        ->assertSee('Kalender Ketersediaan Homestay')
        ->assertSee('Kosong')
        ->assertSee('Berisi')
        ->assertSee('Natasha Garden House');
});
