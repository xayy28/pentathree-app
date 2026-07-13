<?php

namespace Database\Seeders;

use App\Models\Homestay;
use App\Models\Souvenir;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $adminRole = Role::findOrCreate('admin', 'web');
        $userRole = Role::findOrCreate('user', 'web');

        // Seeding Kelompok User
        $this->call(KelompokUserSeeder::class);

        // Seeding Akun Admin
        $admin = User::create([
            'nama' => 'Aura Administrator',
            'email' => 'admin@aura.com',
            'password' => 'admin123', // Otomatis di-hash oleh model User (casts hashed)
            'no_hp' => '081122334455',
            'alamat' => 'Kantor Pusat Aura Stay & Style, Bandung',
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);
        $admin->assignRole($adminRole);

        // Seeding Akun User Biasa
        $user = User::create([
            'nama' => 'Evelyn Thorne',
            'email' => 'user@aura.com',
            'password' => 'user123', // Otomatis di-hash oleh model User (casts hashed)
            'no_hp' => '081234567890',
            'alamat' => 'Jl. Kemuning No. 12, Jakarta Selatan',
            'role' => 'user',
            'email_verified_at' => now(),
        ]);
        $user->assignRole($userRole);

        // Seeding Fasilitas first
        $this->call(FasilitasSeeder::class);

        // Seeding Kategori & Homestay Real Data from Owner request
        $this->call(HomestayRealSeeder::class);

        // Ambil user_id admin untuk updated_by
        $adminId = User::where('role', 'admin')->first()->user_id;

        // Seeding Souvenir Real Data from User Photos
        $this->call(SouvenirRealSeeder::class);

        // Seeding Dummy Transactions for Demo (all souvenirs + homestays + reviews)
        $this->call(DummyTransactionSeeder::class);
    }
}
