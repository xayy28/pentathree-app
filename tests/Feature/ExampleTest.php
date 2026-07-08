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
