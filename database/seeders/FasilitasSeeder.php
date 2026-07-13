<?php

namespace Database\Seeders;

use App\Models\Fasilitas;
use Illuminate\Database\Seeder;

class FasilitasSeeder extends Seeder
{
    /**
     * Seed data fasilitas umum homestay.
     */
    public function run(): void
    {
        $fasilitas = [
            ['nama_fasilitas' => 'WiFi Gratis',        'ikon' => 'wifi'],
            ['nama_fasilitas' => 'AC',                  'ikon' => 'ac'],
            ['nama_fasilitas' => 'Air Panas',           'ikon' => 'shower'],
            ['nama_fasilitas' => 'Parkir Gratis',       'ikon' => 'parking'],
            ['nama_fasilitas' => 'Dapur Bersama',       'ikon' => 'kitchen'],
            ['nama_fasilitas' => 'Kolam Renang',        'ikon' => 'pool'],
            ['nama_fasilitas' => 'TV',                  'ikon' => 'tv'],
            ['nama_fasilitas' => 'Sarapan Tersedia',    'ikon' => 'breakfast'],
            ['nama_fasilitas' => 'Kasur 200x180',       'ikon' => 'bed'],
            ['nama_fasilitas' => 'Ekstra Bed 1',        'ikon' => 'bed'],
            ['nama_fasilitas' => 'Kipas Angin',         'ikon' => 'fan'],
            ['nama_fasilitas' => 'Kamar Mandi Dalam',   'ikon' => 'bath'],
            ['nama_fasilitas' => '2 Botol Air Minum',   'ikon' => 'drink'],
            ['nama_fasilitas' => 'Free Kopi & Sarapan', 'ikon' => 'breakfast'],
        ];

        foreach ($fasilitas as $item) {
            Fasilitas::firstOrCreate(
                ['nama_fasilitas' => $item['nama_fasilitas']],
                ['ikon' => $item['ikon']]
            );
        }
    }
}
