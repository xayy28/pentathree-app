<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seeding Akun Admin
        User::create([
            'nama' => 'Aura Administrator',
            'email' => 'admin@aura.com',
            'password' => 'admin123', // Otomatis di-hash oleh model User (casts hashed)
            'no_hp' => '081122334455',
            'alamat' => 'Kantor Pusat Aura Stay & Style, Bandung',
            'role' => 'admin',
        ]);

        // Seeding Akun User Biasa
        User::create([
            'nama' => 'Evelyn Thorne',
            'email' => 'user@aura.com',
            'password' => 'user123', // Otomatis di-hash oleh model User (casts hashed)
            'no_hp' => '081234567890',
            'alamat' => 'Jl. Kemuning No. 12, Jakarta Selatan',
            'role' => 'user',
        ]);
    }
}
