<?php

use App\Models\Homestay;
use App\Models\KategoriHomestay;
use App\Models\User;
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
});

test('guest cannot access category pages', function () {
    $this->get(route('admin.kategori-homestay'))->assertRedirect(route('login'));
    $this->get(route('admin.kategori-homestay.create'))->assertRedirect(route('login'));
    $this->post(route('admin.kategori-homestay.store'))->assertRedirect(route('login'));
});

test('normal user cannot access category pages', function () {
    $this->actingAs($this->user)->get(route('admin.kategori-homestay'))->assertRedirect(route('dashboard'));
    $this->actingAs($this->user)->get(route('admin.kategori-homestay.create'))->assertRedirect(route('dashboard'));
});

test('admin can access category listing', function () {
    KategoriHomestay::create(['nama_kategori' => 'Suites']);

    $response = $this->actingAs($this->admin)->get(route('admin.kategori-homestay'));
    $response->assertStatus(200);
    $response->assertSee('Suites');
});

test('admin can create a category', function () {
    $data = [
        'nama_kategori' => 'Exclusive Cabins',
        'deskripsi' => 'Premium cabin properties',
    ];

    $response = $this->actingAs($this->admin)->post(route('admin.kategori-homestay.store'), $data);
    $response->assertRedirect(route('admin.kategori-homestay'));

    $this->assertDatabaseHas('kategori_homestays', [
        'nama_kategori' => 'Exclusive Cabins',
    ]);
});

test('admin can edit a category', function () {
    $category = KategoriHomestay::create(['nama_kategori' => 'Deluxe Rooms']);

    $editData = [
        'nama_kategori' => 'Deluxe Cabins',
        'deskripsi' => 'Updated description',
    ];

    $response = $this->actingAs($this->admin)->put(route('admin.kategori-homestay.update', $category->kategori_id), $editData);
    $response->assertRedirect(route('admin.kategori-homestay'));

    $this->assertDatabaseHas('kategori_homestays', [
        'kategori_id' => $category->kategori_id,
        'nama_kategori' => 'Deluxe Cabins',
    ]);
});

test('admin can delete a category without associated homestays', function () {
    $category = KategoriHomestay::create(['nama_kategori' => 'Standard']);

    $response = $this->actingAs($this->admin)->delete(route('admin.kategori-homestay.destroy', $category->kategori_id));
    $response->assertRedirect(route('admin.kategori-homestay'));

    $this->assertDatabaseMissing('kategori_homestays', [
        'kategori_id' => $category->kategori_id,
    ]);
});

test('admin cannot delete a category with associated homestays', function () {
    $category = KategoriHomestay::create(['nama_kategori' => 'Suites']);

    Homestay::create([
        'kategori_id' => $category->kategori_id,
        'nama_homestay' => 'Cendana Suite',
        'harga_permalam' => 1000000,
        'kapasitas' => 2,
        'status' => 'Tersedia',
    ]);

    $response = $this->actingAs($this->admin)->delete(route('admin.kategori-homestay.destroy', $category->kategori_id));
    $response->assertRedirect(route('admin.kategori-homestay'));

    // Check that it fails with error session message
    $response->assertSessionHas('error');

    $this->assertDatabaseHas('kategori_homestays', [
        'kategori_id' => $category->kategori_id,
    ]);
});
