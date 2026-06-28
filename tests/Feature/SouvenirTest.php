<?php

use App\Models\Souvenir;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(DatabaseSeeder::class);
});

test('guest cannot access souvenir pages', function () {
    $this->get(route('admin.souvenir'))->assertRedirect(route('login'));
    $this->get(route('user.souvenir'))->assertRedirect(route('login'));
});

test('admin can access admin souvenir index', function () {
    $admin = User::where('role', 'admin')->first();

    $response = $this->actingAs($admin)->get(route('admin.souvenir'));

    $response->assertStatus(200);
    $response->assertSee('Kelola Souvenir');
});

test('admin can create a souvenir with updated_by set automatically', function () {
    $admin = User::where('role', 'admin')->first();

    $response = $this->actingAs($admin)->post(route('admin.souvenir.store'), [
        'nama_souvenir' => 'Souvenir Khas Bandung',
        'harga' => 25000,
        'stok' => 100,
        'status' => 'Tersedia',
        'detail' => 'Deskripsi souvenir khas',
    ]);

    $response->assertRedirect(route('admin.souvenir'));

    $this->assertDatabaseHas('souvenirs', [
        'nama_souvenir' => 'Souvenir Khas Bandung',
        'harga' => 25000,
        'stok' => 100,
        'updated_by' => $admin->user_id,
    ]);
});

test('admin can update a souvenir with updated_by updated automatically', function () {
    $admin = User::where('role', 'admin')->first();
    $souvenir = Souvenir::first();

    $response = $this->actingAs($admin)->put(route('admin.souvenir.update', $souvenir->souvenir_id), [
        'nama_souvenir' => 'Souvenir Updated Name',
        'harga' => 30000,
        'stok' => 10,
        'status' => 'Habis',
        'detail' => 'Updated detail info',
    ]);

    $response->assertRedirect(route('admin.souvenir'));

    $this->assertDatabaseHas('souvenirs', [
        'souvenir_id' => $souvenir->souvenir_id,
        'nama_souvenir' => 'Souvenir Updated Name',
        'harga' => 30000,
        'status' => 'Habis',
        'updated_by' => $admin->user_id,
    ]);
});

test('user can view souvenir catalog sorted by jumlah_terjual for terlaris', function () {
    $user = User::where('role', 'user')->first();
    $admin = User::where('role', 'admin')->first();

    Souvenir::query()->delete();

    $item1 = Souvenir::create([
        'nama_souvenir' => 'Item Jarang Terjual',
        'harga' => 10000,
        'stok' => 50,
        'status' => 'Tersedia',
        'jumlah_terjual' => 5, // Sedikit terjual
        'updated_by' => $admin->user_id,
    ]);

    $item2 = Souvenir::create([
        'nama_souvenir' => 'Item Paling Laris',
        'harga' => 20000,
        'stok' => 10,
        'status' => 'Tersedia',
        'jumlah_terjual' => 120, // Paling banyak terjual (terlaris)
        'updated_by' => $admin->user_id,
    ]);

    // Default: sorted by latest
    $responseDefault = $this->actingAs($user)->get(route('user.souvenir'));
    $responseDefault->assertStatus(200);

    // Terlaris: sorted by jumlah_terjual desc
    $responseSorted = $this->actingAs($user)->get(route('user.souvenir', ['kategori' => 'terlaris']));
    $responseSorted->assertStatus(200);

    $dataSorted = $responseSorted->original->getData()['souvenirs'];

    // Item dengan jumlah_terjual 120 harus muncul pertama
    expect($dataSorted->first()->souvenir_id)->toBe($item2->souvenir_id);
    expect($dataSorted->last()->souvenir_id)->toBe($item1->souvenir_id);
});

test('souvenir updater relation returns admin name', function () {
    $souvenir = Souvenir::with('updater')->first();

    expect($souvenir->updater)->not->toBeNull();
    expect($souvenir->updater->role)->toBe('admin');
});

test('admin can delete a souvenir', function () {
    $admin = User::where('role', 'admin')->first();
    $souvenir = Souvenir::first();

    $response = $this->actingAs($admin)->delete(route('admin.souvenir.destroy', $souvenir->souvenir_id));

    $response->assertRedirect(route('admin.souvenir'));
    $this->assertDatabaseMissing('souvenirs', [
        'souvenir_id' => $souvenir->souvenir_id,
    ]);
});
