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

        // Ambil user_id admin untuk updated_by
        $adminId = User::where('role', 'admin')->first()->user_id;

        // Seeding Souvenir Mock Data
        \App\Models\Souvenir::create([
            'nama_souvenir' => 'Gantungan Kunci Kayu Estetik',
            'harga' => 15000,
            'stok' => 50,
            'status' => 'Tersedia',
            'detail' => 'Gantungan kunci kayu dengan ukiran khas buatan tangan seniman lokal.',
            'jumlah_terjual' => 120,
            'updated_by' => $adminId,
        ]);

        \App\Models\Souvenir::create([
            'nama_souvenir' => 'Miniatur Rumah Adat Minang',
            'harga' => 125000,
            'stok' => 10,
            'status' => 'Tersedia',
            'detail' => 'Miniatur rumah gadang terbuat dari bambu pilihan dengan detail yang sangat mirip dengan aslinya.',
            'jumlah_terjual' => 15,
            'updated_by' => $adminId,
        ]);

        \App\Models\Souvenir::create([
            'nama_souvenir' => 'Batik Tulis Eksklusif Aura',
            'harga' => 350000,
            'stok' => 5,
            'status' => 'Tersedia',
            'detail' => 'Kain batik tulis premium dengan motif khas Aura Stay yang diproses secara tradisional.',
            'jumlah_terjual' => 45,
            'updated_by' => $adminId,
        ]);

        \App\Models\Souvenir::create([
            'nama_souvenir' => 'Madu Murni Hutan Alami',
            'harga' => 85000,
            'stok' => 0,
            'status' => 'Habis',
            'detail' => 'Madu hutan asli 100% organik dari pedalaman hutan sumatera.',
            'jumlah_terjual' => 80,
            'updated_by' => $adminId,
        ]);
    }
}
