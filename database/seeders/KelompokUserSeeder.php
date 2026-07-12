<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class KelompokUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::findOrCreate('admin', 'web');
        $userRole = Role::findOrCreate('user', 'web');

        $anggota = [
            [
                'nama' => 'Zackri Kurnia Amri',
                'email' => 'zackri@aura.com',
                'password' => 'password123',
                'no_hp' => '081234567801',
                'alamat' => 'Lembah Harau, Sumatera Barat',
                'role' => 'user',
            ],
            [
                'nama' => 'Yelsa Pagansa Putri',
                'email' => 'yelsa@aura.com',
                'password' => 'password123',
                'no_hp' => '081234567802',
                'alamat' => 'Lembah Harau, Sumatera Barat',
                'role' => 'user',
            ],
            [
                'nama' => 'Zikri Ilham Pratama',
                'email' => 'zikri@aura.com',
                'password' => 'password123',
                'no_hp' => '081234567803',
                'alamat' => 'Lembah Harau, Sumatera Barat',
                'role' => 'user',
            ],
            [
                'nama' => 'Muhammad Aufi',
                'email' => 'aufi@aura.com',
                'password' => 'password123',
                'no_hp' => '081234567804',
                'alamat' => 'Lembah Harau, Sumatera Barat',
                'role' => 'user',
            ],
            [
                'nama' => 'Taufiqurrahman',
                'email' => 'taufiq@aura.com',
                'password' => 'password123',
                'no_hp' => '081234567805',
                'alamat' => 'Lembah Harau, Sumatera Barat',
                'role' => 'user',
            ],
        ];

        foreach ($anggota as $data) {
            // Hapus jika user dengan email tersebut sudah ada sebelumnya untuk menghindari duplikasi
            User::where('email', $data['email'])->delete();

            $user = User::create([
                'nama' => $data['nama'],
                'email' => $data['email'],
                'password' => $data['password'], // Di-hash otomatis oleh model User casts
                'no_hp' => $data['no_hp'],
                'alamat' => $data['alamat'],
                'role' => $data['role'],
                'email_verified_at' => now(),
            ]);

            // Assign role Spatie
            if ($data['role'] === 'admin') {
                $user->assignRole($adminRole);
            } else {
                $user->assignRole($userRole);
            }
        }
    }
}
