<?php

use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('database seeder assigns spatie roles to demo users', function () {
    $this->seed(DatabaseSeeder::class);

    $admin = User::where('email', 'admin@aura.com')->firstOrFail();
    $user = User::where('email', 'user@aura.com')->firstOrFail();

    expect($admin->hasRole('admin'))->toBeTrue();
    expect($user->hasRole('user'))->toBeTrue();

    $this->assertDatabaseHas('roles', [
        'name' => 'admin',
        'guard_name' => 'web',
    ]);
    $this->assertDatabaseHas('roles', [
        'name' => 'user',
        'guard_name' => 'web',
    ]);
});

test('registration assigns user spatie role', function () {
    $response = $this->post(route('register'), [
        'nama' => 'Pelanggan Baru',
        'email' => 'pelanggan@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'no_hp' => '081234567891',
        'alamat' => 'Padang',
    ]);

    $response->assertRedirect('/dashboard');

    $user = User::where('email', 'pelanggan@example.com')->firstOrFail();

    expect($user->role)->toBe('user');
    expect($user->hasRole('user'))->toBeTrue();
});

test('legacy role column still allows access before spatie role sync', function () {
    $admin = User::create([
        'nama' => 'Legacy Admin',
        'email' => 'legacy-admin@example.com',
        'password' => bcrypt('password123'),
        'no_hp' => '081234567892',
        'alamat' => 'Padang',
        'role' => 'admin',
    ]);

    expect($admin->hasRole('admin'))->toBeFalse();

    $this->actingAs($admin)
        ->get(route('admin.dashboard'))
        ->assertOk();
});
