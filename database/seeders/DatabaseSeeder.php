<?php

namespace Database\Seeders;

use App\Models\Homestay;
use App\Models\KategoriHomestay;
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

        // Seeding Akun Admin
        $admin = User::create([
            'nama' => 'Aura Administrator',
            'email' => 'admin@aura.com',
            'password' => 'admin123', // Otomatis di-hash oleh model User (casts hashed)
            'no_hp' => '081122334455',
            'alamat' => 'Kantor Pusat Aura Stay & Style, Bandung',
            'role' => 'admin',
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
        ]);
        $user->assignRole($userRole);

        // Seeding Kategori Homestay
        $suites = KategoriHomestay::create([
            'nama_kategori' => 'Suites',
            'deskripsi' => 'Kamar tipe Suite dengan kenyamanan ekstra dan fasilitas premium.',
        ]);

        $deluxe = KategoriHomestay::create([
            'nama_kategori' => 'Deluxe',
            'deskripsi' => 'Kamar tipe Deluxe dengan perabotan lengkap dan desain modern.',
        ]);

        $standard = KategoriHomestay::create([
            'nama_kategori' => 'Standard',
            'deskripsi' => 'Kamar tipe Standard dengan harga terjangkau dan fasilitas dasar lengkap.',
        ]);

        // Seeding Homestay
        Homestay::create([
            'kategori_id' => $suites->kategori_id,
            'nama_homestay' => 'Cendana Forest Suite',
            'harga_permalam' => 1250000,
            'kapasitas' => 2,
            'status' => 'Tersedia',
            'detail' => 'Rasakan ketenangan di tengah hutan pinus dengan fasilitas modern dan desain arsitektur kontemporer.',
            'foto' => 'images/hero-banner1.png',
        ]);

        Homestay::create([
            'kategori_id' => $deluxe->kategori_id,
            'nama_homestay' => 'Jati Deluxe Room',
            'harga_permalam' => 900000,
            'kapasitas' => 2,
            'status' => 'Tersedia',
            'detail' => 'Kamar elegan dengan sentuhan kayu Jati otentik, memberikan kehangatan dan kenyamanan maksimal.',
            'foto' => 'images/hero-banner1.png',
        ]);

        Homestay::create([
            'kategori_id' => $standard->kategori_id,
            'nama_homestay' => 'Mahoni Standard Room',
            'harga_permalam' => 650000,
            'kapasitas' => 2,
            'status' => 'Tersedia',
            'detail' => 'Pilihan tepat untuk pelancong bisnis maupun liburan singkat, menawarkan kesederhanaan yang berkelas.',
            'foto' => 'images/hero-banner1.png',
        ]);

        Homestay::create([
            'kategori_id' => $suites->kategori_id,
            'nama_homestay' => 'Meranti Premiere Suite',
            'harga_permalam' => 2100000,
            'kapasitas' => 4,
            'status' => 'Tersedia',
            'detail' => 'Definisi kemewahan yang sesungguhnya dengan ruang tamu pribadi dan pemandangan taman tropis.',
            'foto' => 'images/hero-banner1.png',
        ]);

        // Ambil user_id admin untuk updated_by
        $adminId = User::where('role', 'admin')->first()->user_id;

        // Seeding Souvenir Mock Data
        Souvenir::create([
            'nama_souvenir' => 'Gantungan Kunci Kayu Estetik',
            'harga' => 15000,
            'stok' => 50,
            'status' => 'Tersedia',
            'detail' => 'Gantungan kunci kayu dengan ukiran khas buatan tangan seniman lokal.',
            'jumlah_terjual' => 120,
            'updated_by' => $adminId,
        ]);

        Souvenir::create([
            'nama_souvenir' => 'Miniatur Rumah Adat Minang',
            'harga' => 125000,
            'stok' => 10,
            'status' => 'Tersedia',
            'detail' => 'Miniatur rumah gadang terbuat dari bambu pilihan dengan detail yang sangat mirip dengan aslinya.',
            'jumlah_terjual' => 15,
            'updated_by' => $adminId,
        ]);

        Souvenir::create([
            'nama_souvenir' => 'Batik Tulis Eksklusif Aura',
            'harga' => 350000,
            'stok' => 5,
            'status' => 'Tersedia',
            'detail' => 'Kain batik tulis premium dengan motif khas Aura Stay yang diproses secara tradisional.',
            'jumlah_terjual' => 45,
            'updated_by' => $adminId,
        ]);

        Souvenir::create([
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
