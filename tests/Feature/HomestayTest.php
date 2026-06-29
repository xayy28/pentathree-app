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

test('admin can filter homestay listing by category and status', function () {
    $otherCategory = KategoriHomestay::create([
        'nama_kategori' => 'Budget Rooms',
    ]);

    $availableHomestay = Homestay::create([
        'kategori_id' => $this->category->kategori_id,
        'nama_homestay' => 'Cendana Suite',
        'harga_permalam' => 1000000,
        'kapasitas' => 2,
        'status' => 'Tersedia',
    ]);

    Homestay::create([
        'kategori_id' => $otherCategory->kategori_id,
        'nama_homestay' => 'Mahoni Room',
        'harga_permalam' => 500000,
        'kapasitas' => 2,
        'status' => 'Tidak Tersedia',
    ]);

    $response = $this->actingAs($this->admin)->get(route('admin.homestay', [
        'kategori' => $availableHomestay->kategori_id,
        'status' => 'Tersedia',
    ]));

    $response->assertStatus(200);
    $response->assertSee('Cendana Suite');
    $response->assertDontSee('Mahoni Room');
});

test('user can filter homestay catalog by category status and guest capacity', function () {
    $otherCategory = KategoriHomestay::create([
        'nama_kategori' => 'Budget Rooms',
    ]);

    Homestay::create([
        'kategori_id' => $this->category->kategori_id,
        'nama_homestay' => 'Cendana Suite',
        'harga_permalam' => 1000000,
        'kapasitas' => 4,
        'status' => 'Tersedia',
    ]);

    Homestay::create([
        'kategori_id' => $otherCategory->kategori_id,
        'nama_homestay' => 'Mahoni Room',
        'harga_permalam' => 500000,
        'kapasitas' => 4,
        'status' => 'Tersedia',
    ]);

    Homestay::create([
        'kategori_id' => $this->category->kategori_id,
        'nama_homestay' => 'Pinus Compact Room',
        'harga_permalam' => 350000,
        'kapasitas' => 2,
        'status' => 'Tersedia',
    ]);

    Homestay::create([
        'kategori_id' => $this->category->kategori_id,
        'nama_homestay' => 'Akasia Maintenance Room',
        'harga_permalam' => 400000,
        'kapasitas' => 4,
        'status' => 'Tidak Tersedia',
    ]);

    $response = $this->actingAs($this->user)->get(route('user.homestay', [
        'kategori' => $this->category->kategori_id,
        'status' => 'Tersedia',
        'tamu' => 3,
    ]));

    $response->assertStatus(200);
    $response->assertSee('Cendana Suite');
    $response->assertDontSee('Mahoni Room');
    $response->assertDontSee('Pinus Compact Room');
    $response->assertDontSee('Akasia Maintenance Room');
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

test('admin cannot create homestay with invalid status', function () {
    $this->actingAs($this->admin)->post(route('admin.homestay.store'), [
        'kategori_id' => $this->category->kategori_id,
        'nama_homestay' => 'Invalid Status Room',
        'harga_permalam' => 850000,
        'kapasitas' => 3,
        'status' => 'Maintenance',
        'detail' => 'Invalid status sample',
    ])->assertSessionHasErrors('status');

    $this->assertDatabaseMissing('homestays', [
        'nama_homestay' => 'Invalid Status Room',
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
