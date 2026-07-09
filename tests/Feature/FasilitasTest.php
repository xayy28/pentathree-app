<?php

use App\Models\Fasilitas;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->admin = User::create([
        'nama' => 'Aura Admin',
        'email' => 'admin.fasilitas@aura.com',
        'password' => bcrypt('admin123'),
        'no_hp' => '081122334455',
        'alamat' => 'Bandung',
        'role' => 'admin',
    ]);

    $this->user = User::create([
        'nama' => 'Aura User',
        'email' => 'user.fasilitas@aura.com',
        'password' => bcrypt('user123'),
        'no_hp' => '081234567890',
        'alamat' => 'Bandung',
        'role' => 'user',
    ]);
});

test('guest cannot access fasilitas pages', function () {
    $this->get(route('admin.fasilitas'))->assertRedirect(route('login'));
    $this->get(route('admin.fasilitas.create'))->assertRedirect(route('login'));
    $this->post(route('admin.fasilitas.store'))->assertRedirect(route('login'));
});

test('normal user cannot access fasilitas pages', function () {
    $this->actingAs($this->user)->get(route('admin.fasilitas'))->assertRedirect(route('dashboard'));
    $this->actingAs($this->user)->get(route('admin.fasilitas.create'))->assertRedirect(route('dashboard'));
});

test('admin can access fasilitas listing', function () {
    Fasilitas::create([
        'nama_fasilitas' => 'WiFi Gratis',
        'ikon' => 'wifi',
    ]);

    $response = $this->actingAs($this->admin)->get(route('admin.fasilitas'));

    $response->assertStatus(200);
    $response->assertSee('WiFi Gratis');
});

test('admin can create fasilitas', function () {
    $response = $this->actingAs($this->admin)->post(route('admin.fasilitas.store'), [
        'nama_fasilitas' => 'Kolam Renang',
        'ikon' => 'pool',
    ]);

    $response->assertRedirect(route('admin.fasilitas'));

    $this->assertDatabaseHas('fasilitas', [
        'nama_fasilitas' => 'Kolam Renang',
        'ikon' => 'pool',
    ]);
});

test('admin cannot create duplicate fasilitas name', function () {
    Fasilitas::create([
        'nama_fasilitas' => 'Air Panas',
        'ikon' => 'shower',
    ]);

    $this->actingAs($this->admin)->post(route('admin.fasilitas.store'), [
        'nama_fasilitas' => 'Air Panas',
        'ikon' => 'water',
    ])->assertSessionHasErrors('nama_fasilitas');

    $this->assertDatabaseCount('fasilitas', 1);
});

test('admin can update fasilitas', function () {
    $fasilitas = Fasilitas::create([
        'nama_fasilitas' => 'Parkir',
        'ikon' => 'parking',
    ]);

    $response = $this->actingAs($this->admin)->put(route('admin.fasilitas.update', $fasilitas->fasilitas_id), [
        'nama_fasilitas' => 'Parkir Gratis',
        'ikon' => 'car',
    ]);

    $response->assertRedirect(route('admin.fasilitas'));

    $this->assertDatabaseHas('fasilitas', [
        'fasilitas_id' => $fasilitas->fasilitas_id,
        'nama_fasilitas' => 'Parkir Gratis',
        'ikon' => 'car',
    ]);
});

test('admin cannot update fasilitas to duplicate name', function () {
    Fasilitas::create([
        'nama_fasilitas' => 'AC',
        'ikon' => 'ac',
    ]);

    $fasilitas = Fasilitas::create([
        'nama_fasilitas' => 'Kipas Angin',
        'ikon' => 'fan',
    ]);

    $this->actingAs($this->admin)->put(route('admin.fasilitas.update', $fasilitas->fasilitas_id), [
        'nama_fasilitas' => 'AC',
        'ikon' => 'fan',
    ])->assertSessionHasErrors('nama_fasilitas');

    $this->assertDatabaseHas('fasilitas', [
        'fasilitas_id' => $fasilitas->fasilitas_id,
        'nama_fasilitas' => 'Kipas Angin',
    ]);
});

test('admin can delete fasilitas', function () {
    $fasilitas = Fasilitas::create([
        'nama_fasilitas' => 'Dapur Bersama',
        'ikon' => 'kitchen',
    ]);

    $response = $this->actingAs($this->admin)->delete(route('admin.fasilitas.destroy', $fasilitas->fasilitas_id));

    $response->assertRedirect(route('admin.fasilitas'));

    $this->assertDatabaseMissing('fasilitas', [
        'fasilitas_id' => $fasilitas->fasilitas_id,
    ]);
});
