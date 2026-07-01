<?php

use App\Models\DetailPemesanan;
use App\Models\Homestay;
use App\Models\Pemesanan;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(DatabaseSeeder::class);
    $this->user = User::where('role', 'user')->first();
    $this->admin = User::where('role', 'admin')->first();
    $this->homestay = Homestay::where('status', 'Tersedia')->first();
});

test('guest cannot access homestay booking form', function () {
    $this->get(route('user.homestay.booking.create', $this->homestay->homestay_id))
        ->assertRedirect(route('login'));
});

test('admin cannot access user homestay booking form', function () {
    $this->actingAs($this->admin)
        ->get(route('user.homestay.booking.create', $this->homestay->homestay_id))
        ->assertRedirect(route('admin.dashboard'));
});

test('user can open homestay booking form', function () {
    $this->actingAs($this->user)
        ->get(route('user.homestay.booking.create', $this->homestay->homestay_id))
        ->assertStatus(200)
        ->assertSee($this->homestay->nama_homestay);
});

test('legacy reservation routes redirect to active order and booking flows', function () {
    $this->actingAs($this->user)
        ->get(route('user.reservasi'))
        ->assertRedirect(route('user.pesanan.index'));

    $this->actingAs($this->user)
        ->get(route('user.reservasi.create', $this->homestay->homestay_id))
        ->assertRedirect(route('user.homestay.booking.create', $this->homestay->homestay_id));
});

test('user can create homestay booking as pemesanan', function () {
    $checkIn = now()->addDay()->toDateString();
    $checkOut = now()->addDays(3)->toDateString();
    $expectedTotal = $this->homestay->harga_permalam * 2;

    $response = $this->actingAs($this->user)
        ->post(route('user.homestay.booking.store', $this->homestay->homestay_id), [
            'check_in' => $checkIn,
            'check_out' => $checkOut,
            'jumlah_tamu' => 1,
        ]);

    $pemesanan = Pemesanan::with('detailPemesanans')->first();

    $response->assertRedirect(route('user.pembayaran.create', $pemesanan->pemesanan_id));
    $response->assertSessionHas('success');

    expect($pemesanan->user_id)->toBe($this->user->user_id);
    expect($pemesanan->jenis_pemesanan)->toBe(Pemesanan::JENIS_HOMESTAY);
    expect($pemesanan->status_pemesanan)->toBe(Pemesanan::STATUS_MENUNGGU_PEMBAYARAN);
    expect((float) $pemesanan->total_harga)->toBe((float) $expectedTotal);

    $detail = $pemesanan->detailPemesanans->first();
    expect($detail->homestay_id)->toBe($this->homestay->homestay_id);
    expect($detail->nama_item)->toBe($this->homestay->nama_homestay);
    expect($detail->jumlah_malam)->toBe(2);
    expect((float) $detail->subtotal)->toBe((float) $expectedTotal);
});

test('booking requires checkout date after checkin date', function () {
    $this->actingAs($this->user)
        ->post(route('user.homestay.booking.store', $this->homestay->homestay_id), [
            'check_in' => now()->addDay()->toDateString(),
            'check_out' => now()->addDay()->toDateString(),
            'jumlah_tamu' => 1,
        ])
        ->assertSessionHasErrors('check_out');

    expect(Pemesanan::count())->toBe(0);
    expect(DetailPemesanan::count())->toBe(0);
});

test('booking rejects past checkin date', function () {
    $this->actingAs($this->user)
        ->post(route('user.homestay.booking.store', $this->homestay->homestay_id), [
            'check_in' => now()->subDay()->toDateString(),
            'check_out' => now()->addDay()->toDateString(),
            'jumlah_tamu' => 1,
        ])
        ->assertSessionHasErrors('check_in');

    expect(Pemesanan::count())->toBe(0);
    expect(DetailPemesanan::count())->toBe(0);
});

test('booking rejects guest count above homestay capacity', function () {
    $this->actingAs($this->user)
        ->post(route('user.homestay.booking.store', $this->homestay->homestay_id), [
            'check_in' => now()->addDay()->toDateString(),
            'check_out' => now()->addDays(2)->toDateString(),
            'jumlah_tamu' => $this->homestay->kapasitas + 1,
        ])
        ->assertSessionHasErrors('jumlah_tamu');

    expect(Pemesanan::count())->toBe(0);
    expect(DetailPemesanan::count())->toBe(0);
});
