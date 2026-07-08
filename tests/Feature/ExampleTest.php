<?php

use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(DatabaseSeeder::class);
});

test('homepage renders for guest', function () {
    $this->get('/')
        ->assertStatus(200)
        ->assertSee('Natasha Homestay');
});

test('logged-in user is redirected to dashboard from homepage', function () {
    $user = \App\Models\User::where('role', 'user')->first();

    $this->actingAs($user)
        ->get('/')
        ->assertRedirect(route('dashboard'));
});

test('admin is redirected to admin dashboard from homepage', function () {
    $admin = \App\Models\User::where('role', 'admin')->first();

    $this->actingAs($admin)
        ->get('/')
        ->assertRedirect(route('admin.dashboard'));
});

test('user dashboard shows real review rating aggregates', function () {
    $user = \App\Models\User::where('role', 'user')->first();
    $homestay = \App\Models\Homestay::where('status', 'Tersedia')->latest()->first();

    $pemesanan = \App\Models\Pemesanan::create([
        'user_id' => $user->user_id,
        'jenis_pemesanan' => \App\Models\Pemesanan::JENIS_HOMESTAY,
        'tanggal_pemesanan' => now(),
        'total_harga' => 200000,
        'status_pemesanan' => \App\Models\Pemesanan::STATUS_SELESAI,
    ]);

    foreach ([3, 5] as $rating) {
        $detail = \App\Models\DetailPemesanan::create([
            'pemesanan_id' => $pemesanan->pemesanan_id,
            'homestay_id' => $homestay->homestay_id,
            'nama_item' => $homestay->nama_homestay,
            'harga' => 100000,
            'jumlah' => 1,
            'check_in' => now()->addDay()->toDateString(),
            'check_out' => now()->addDays(2)->toDateString(),
            'jumlah_malam' => 1,
            'subtotal' => 100000,
        ]);

        \App\Models\Ulasan::create([
            'user_id' => $user->user_id,
            'pemesanan_id' => $pemesanan->pemesanan_id,
            'detail_pemesanan_id' => $detail->detail_pemesanan_id,
            'homestay_id' => $homestay->homestay_id,
            'rating' => $rating,
            'komentar' => 'Rating dashboard real.',
        ]);
    }

    $this->actingAs($user)
        ->get(route('dashboard'))
        ->assertOk()
        ->assertSee('4.0')
        ->assertSee('2 Ulasan')
        ->assertDontSee('>4.8</p>', false);
});
