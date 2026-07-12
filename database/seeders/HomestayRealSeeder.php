<?php

namespace Database\Seeders;

use App\Models\Fasilitas;
use App\Models\Homestay;
use App\Models\KategoriHomestay;
use Illuminate\Database\Seeder;

class HomestayRealSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Buat Kategori Lantai 1 dan Lantai 2
        $lantai1 = KategoriHomestay::firstOrCreate([
            'nama_kategori' => 'Lantai 1',
        ], [
            'deskripsi' => 'Kamar homestay yang terletak di Lantai 1.',
        ]);

        $lantai2 = KategoriHomestay::firstOrCreate([
            'nama_kategori' => 'Lantai 2',
        ], [
            'deskripsi' => 'Kamar homestay yang terletak di Lantai 2.',
        ]);

        // 2. Siapkan Fasilitas
        $fasilitasNames = [
            'Kasur 200x180',
            'Ekstra Bed 1',
            'Kipas Angin',
            'Kamar Mandi Dalam',
            '2 Botol Air Minum',
            'Free Kopi & Sarapan'
        ];
        
        $fasilitasIds = Fasilitas::whereIn('nama_fasilitas', $fasilitasNames)
            ->pluck('fasilitas_id')
            ->toArray();

        // 3. Buat 4 Kamar Homestay
        $rooms = [
            [
                'kategori_id' => $lantai1->kategori_id,
                'nama_homestay' => 'Kamar 101 Lantai 1',
                'harga_permalam' => 450000, // Harga default
                'kapasitas' => 8,
                'status' => 'Tersedia',
                'detail' => 'Kamar Homestay Lantai 1 berkapasitas besar cocok untuk keluarga dan rombongan (6-8 orang). Fasilitas lengkap dengan kasur nyaman, kipas angin, kamar mandi dalam, serta free kopi dan sarapan.',
                'foto' => 'images/hero-banner1.png',
            ],
            [
                'kategori_id' => $lantai1->kategori_id,
                'nama_homestay' => 'Kamar 102 Lantai 1',
                'harga_permalam' => 450000,
                'kapasitas' => 8,
                'status' => 'Tersedia',
                'detail' => 'Kamar Homestay Lantai 1 berkapasitas besar cocok untuk keluarga dan rombongan (6-8 orang). Fasilitas lengkap dengan kasur nyaman, kipas angin, kamar mandi dalam, serta free kopi dan sarapan.',
                'foto' => 'images/hero-banner1.png',
            ],
            [
                'kategori_id' => $lantai2->kategori_id,
                'nama_homestay' => 'Kamar 201 Lantai 2',
                'harga_permalam' => 450000,
                'kapasitas' => 8,
                'status' => 'Tersedia',
                'detail' => 'Kamar Homestay Lantai 2 berkapasitas besar cocok untuk keluarga dan rombongan (6-8 orang). Fasilitas lengkap dengan kasur nyaman, kipas angin, kamar mandi dalam, serta free kopi dan sarapan.',
                'foto' => 'images/hero-banner1.png',
            ],
            [
                'kategori_id' => $lantai2->kategori_id,
                'nama_homestay' => 'Kamar 202 Lantai 2',
                'harga_permalam' => 450000,
                'kapasitas' => 8,
                'status' => 'Tersedia',
                'detail' => 'Kamar Homestay Lantai 2 berkapasitas besar cocok untuk keluarga dan rombongan (6-8 orang). Fasilitas lengkap dengan kasur nyaman, kipas angin, kamar mandi dalam, serta free kopi dan sarapan.',
                'foto' => 'images/hero-banner1.png',
            ],
        ];

        foreach ($rooms as $roomData) {
            // Cek apakah homestay dengan nama ini sudah ada, jika ada hapus dulu biar bersih
            Homestay::where('nama_homestay', $roomData['nama_homestay'])->delete();

            $homestay = Homestay::create($roomData);

            // Sambungkan dengan fasilitas
            if (!empty($fasilitasIds)) {
                $homestay->fasilitas()->sync($fasilitasIds);
            }
        }
    }
}
