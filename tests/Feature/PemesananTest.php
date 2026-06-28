<?php

use App\Models\DetailPemesanan;
use App\Models\Homestay;
use App\Models\Pemesanan;
use App\Models\Souvenir;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(DatabaseSeeder::class);
    $this->user = User::where('role', 'user')->first();
    $this->homestay = Homestay::first();
    $this->souvenir = Souvenir::first();
});

test('user can have many pemesanans', function () {
    Pemesanan::create([
        'user_id' => $this->user->user_id,
        'jenis_pemesanan' => Pemesanan::JENIS_SOUVENIR,
        'total_harga' => 15000,
    ]);

    Pemesanan::create([
        'user_id' => $this->user->user_id,
        'jenis_pemesanan' => Pemesanan::JENIS_HOMESTAY,
        'total_harga' => 1250000,
    ]);

    expect($this->user->pemesanans()->count())->toBe(2);
});

test('pemesanan can have many detail pemesanans', function () {
    $pemesanan = Pemesanan::create([
        'user_id' => $this->user->user_id,
        'jenis_pemesanan' => Pemesanan::JENIS_SOUVENIR,
        'total_harga' => 30000,
    ]);

    DetailPemesanan::create([
        'pemesanan_id' => $pemesanan->pemesanan_id,
        'souvenir_id' => $this->souvenir->souvenir_id,
        'nama_item' => $this->souvenir->nama_souvenir,
        'harga' => 15000,
        'jumlah' => 1,
        'subtotal' => 15000,
    ]);

    DetailPemesanan::create([
        'pemesanan_id' => $pemesanan->pemesanan_id,
        'souvenir_id' => $this->souvenir->souvenir_id,
        'nama_item' => $this->souvenir->nama_souvenir,
        'harga' => 15000,
        'jumlah' => 1,
        'subtotal' => 15000,
    ]);

    expect($pemesanan->detailPemesanans()->count())->toBe(2);
});

test('detail pemesanan can belong to souvenir', function () {
    $pemesanan = Pemesanan::create([
        'user_id' => $this->user->user_id,
        'jenis_pemesanan' => Pemesanan::JENIS_SOUVENIR,
        'total_harga' => 15000,
    ]);

    $detail = DetailPemesanan::create([
        'pemesanan_id' => $pemesanan->pemesanan_id,
        'souvenir_id' => $this->souvenir->souvenir_id,
        'nama_item' => $this->souvenir->nama_souvenir,
        'harga' => 15000,
        'jumlah' => 1,
        'subtotal' => 15000,
    ]);

    expect($detail->souvenir->souvenir_id)->toBe($this->souvenir->souvenir_id);
    expect($this->souvenir->detailPemesanans()->first()->detail_pemesanan_id)->toBe($detail->detail_pemesanan_id);
});

test('detail pemesanan can belong to homestay', function () {
    $pemesanan = Pemesanan::create([
        'user_id' => $this->user->user_id,
        'jenis_pemesanan' => Pemesanan::JENIS_HOMESTAY,
        'total_harga' => 1250000,
    ]);

    $detail = DetailPemesanan::create([
        'pemesanan_id' => $pemesanan->pemesanan_id,
        'homestay_id' => $this->homestay->homestay_id,
        'nama_item' => $this->homestay->nama_homestay,
        'harga' => 1250000,
        'jumlah' => 1,
        'check_in' => now()->addDay()->toDateString(),
        'check_out' => now()->addDays(2)->toDateString(),
        'jumlah_malam' => 1,
        'subtotal' => 1250000,
    ]);

    expect($detail->homestay->homestay_id)->toBe($this->homestay->homestay_id);
    expect($this->homestay->detailPemesanans()->first()->detail_pemesanan_id)->toBe($detail->detail_pemesanan_id);
});

test('pemesanan code is generated automatically', function () {
    $first = Pemesanan::create([
        'user_id' => $this->user->user_id,
        'jenis_pemesanan' => Pemesanan::JENIS_SOUVENIR,
        'total_harga' => 15000,
    ]);

    $second = Pemesanan::create([
        'user_id' => $this->user->user_id,
        'jenis_pemesanan' => Pemesanan::JENIS_SOUVENIR,
        'total_harga' => 30000,
    ]);

    expect($first->kode_pemesanan)->toMatch('/^PMS-\d{8}-0001$/');
    expect($second->kode_pemesanan)->toMatch('/^PMS-\d{8}-0002$/');
});

test('pemesanan total harga is stored correctly', function () {
    $pemesanan = Pemesanan::create([
        'user_id' => $this->user->user_id,
        'jenis_pemesanan' => Pemesanan::JENIS_SOUVENIR,
        'total_harga' => 45000,
    ]);

    expect((float) $pemesanan->total_harga)->toBe(45000.0);

    $this->assertDatabaseHas('pemesanans', [
        'pemesanan_id' => $pemesanan->pemesanan_id,
        'total_harga' => 45000,
    ]);
});
