<?php

use App\Models\User;
use App\Models\KategoriHomestay;
use App\Models\Homestay;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Seed user admin & user biasa
    $this->admin = User::create([
        'nama' => 'Aura Admin',
        'email' => 'admin@aura.com',
        'password' => bcrypt('admin123'),
        'no_hp' => '081122334455',
        'alamat' => 'Bandung',
        'role' => 'admin',
    ]);

    $this->user = User::create([
        'nama' => 'Aura User',
        'email' => 'user@aura.com',
        'password' => bcrypt('user123'),
        'no_hp' => '081234567890',
        'alamat' => 'Bandung',
        'role' => 'user',
    ]);

    $this->category = KategoriHomestay::create([
        'nama_kategori' => 'Exclusive Cabins',
        'deskripsi' => 'Premium cabin properties',
    ]);
});

test('guest cannot access homestay pages', function () {
    $this->get(route('admin.homestay'))->assertRedirect(route('login'));
    $this->get(route('admin.homestay.create'))->assertRedirect(route('login'));
    $this->post(route('admin.homestay.store'))->assertRedirect(route('login'));
});

test('normal user cannot access admin homestay pages', function () {
    $this->actingAs($this->user)->get(route('admin.homestay'))->assertRedirect(route('dashboard'));
    $this->actingAs($this->user)->get(route('admin.homestay.create'))->assertRedirect(route('dashboard'));
});

test('admin can access homestay listing', function () {
    Homestay::create([
        'kategori_id' => $this->category->kategori_id,
        'nama_homestay' => 'Cendana Suite',
        'harga_permalam' => 1000000,
        'kapasitas' => 2,
        'status' => 'Tersedia',
    ]);

    $response = $this->actingAs($this->admin)->get(route('admin.homestay'));
    $response->assertStatus(200);
    $response->assertSee('Cendana Suite');
    $response->assertSee('Exclusive Cabins');
});

test('admin can create a homestay with category', function () {
    $data = [
        'kategori_id' => $this->category->kategori_id,
        'nama_homestay' => 'Jati Deluxe Room',
        'harga_permalam' => 850000,
        'kapasitas' => 3,
        'status' => 'Tersedia',
        'detail' => 'Kamar deluxe eksklusif',
    ];

    $response = $this->actingAs($this->admin)->post(route('admin.homestay.store'), $data);
    $response->assertRedirect(route('admin.homestay'));

    $this->assertDatabaseHas('homestays', [
        'nama_homestay' => 'Jati Deluxe Room',
        'kategori_id' => $this->category->kategori_id,
        'harga_permalam' => 850000,
    ]);
});

test('admin can edit a homestay category', function () {
    $homestay = Homestay::create([
        'kategori_id' => $this->category->kategori_id,
        'nama_homestay' => 'Cendana Suite',
        'harga_permalam' => 1000000,
        'kapasitas' => 2,
        'status' => 'Tersedia',
    ]);

    $newCategory = KategoriHomestay::create(['nama_kategori' => 'Suites']);

    $editData = [
        'kategori_id' => $newCategory->kategori_id,
        'nama_homestay' => 'Cendana Premiere Suite',
        'harga_permalam' => 1200000,
        'kapasitas' => 4,
        'status' => 'Tidak Tersedia',
        'detail' => 'Updated details',
    ];

    $response = $this->actingAs($this->admin)->put(route('admin.homestay.update', $homestay->homestay_id), $editData);
    $response->assertRedirect(route('admin.homestay'));

    $this->assertDatabaseHas('homestays', [
        'homestay_id' => $homestay->homestay_id,
        'nama_homestay' => 'Cendana Premiere Suite',
        'kategori_id' => $newCategory->kategori_id,
        'harga_permalam' => 1200000,
        'status' => 'Tidak Tersedia',
    ]);
});

test('admin can delete a homestay', function () {
    $homestay = Homestay::create([
        'kategori_id' => $this->category->kategori_id,
        'nama_homestay' => 'Mahoni Room',
        'harga_permalam' => 500000,
        'kapasitas' => 2,
        'status' => 'Tersedia',
    ]);

    $response = $this->actingAs($this->admin)->delete(route('admin.homestay.destroy', $homestay->homestay_id));
    $response->assertRedirect(route('admin.homestay'));

    $this->assertDatabaseMissing('homestays', [
        'homestay_id' => $homestay->homestay_id,
    ]);
});
