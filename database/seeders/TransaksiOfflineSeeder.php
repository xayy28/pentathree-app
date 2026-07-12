<?php

namespace Database\Seeders;

use App\Models\DetailPemesanan;
use App\Models\Homestay;
use App\Models\Invoice;
use App\Models\Pembayaran;
use App\Models\Pemesanan;
use App\Models\Souvenir;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TransaksiOfflineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminId = User::where('role', 'admin')->first()?->user_id;

        // --- 1. SEED DATA OFFLINE SOUVENIR ---
        $souvenirsOffline = [
            [
                'nama' => 'Pembeli Offline 27/01',
                'email' => 'pembeli.offline2701@gmail.com',
                'no_hp' => '080000000001',
                'qty' => 20,
                'total' => 885000,
                'dibayar' => 885000,
                'metode' => 'Cash',
                'status' => 'lunas',
                'tanggal' => '2026-01-27 14:00:00'
            ],
            [
                'nama' => 'Ipit',
                'email' => 'ipit@gmail.com',
                'no_hp' => '080000000002',
                'qty' => 30,
                'total' => 865000,
                'dibayar' => 865000,
                'metode' => 'Cash',
                'status' => 'lunas',
                'tanggal' => '2026-02-15 15:30:00'
            ],
            [
                'nama' => 'Ginda',
                'email' => 'ginda@gmail.com',
                'no_hp' => '080000000003',
                'qty' => 15,
                'total' => 520000,
                'dibayar' => 520000,
                'metode' => 'Cash',
                'status' => 'lunas',
                'tanggal' => '2026-04-16 11:20:00'
            ],
            [
                'nama' => 'Pembeli Offline 9 Jenis Barang',
                'email' => 'pembeli.9jenis@gmail.com',
                'no_hp' => '080000000004',
                'qty' => 45,
                'total' => 1615000,
                'dibayar' => 1615000,
                'metode' => 'Cash',
                'status' => 'lunas',
                'tanggal' => '2026-04-20 16:45:00'
            ],
            [
                'nama' => 'Pembeli Offline 4 Jenis Barang',
                'email' => 'pembeli.4jenis@gmail.com',
                'no_hp' => '080000000005',
                'qty' => 40,
                'total' => 1960000,
                'dibayar' => 1960000,
                'metode' => 'Cash',
                'status' => 'lunas',
                'tanggal' => '2026-04-22 10:15:00'
            ],
            [
                'nama' => 'Rara',
                'email' => 'rara@gmail.com',
                'no_hp' => '080000000006',
                'qty' => 75,
                'total' => 2160000,
                'dibayar' => 1700000,
                'metode' => 'Cash',
                'status' => 'belum_lunas', // Piutang Rp 460.000
                'tanggal' => '2026-04-03 13:00:00'
            ],
        ];

        // Dapatkan satu souvenir id sebagai referensi jika diperlukan
        $souvenirRef = Souvenir::first();

        foreach ($souvenirsOffline as $idx => $data) {
            // Buat User Pembeli
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'nama' => $data['nama'],
                    'password' => 'password123',
                    'no_hp' => $data['no_hp'],
                    'alamat' => 'Pembelian Offline',
                    'role' => 'user',
                    'email_verified_at' => now(),
                ]
            );

            // Buat Pemesanan
            $pemesanan = Pemesanan::create([
                'user_id' => $user->user_id,
                'kode_pemesanan' => 'PMS-OFFLINE-S' . str_pad($idx + 1, 3, '0', STR_PAD_LEFT),
                'jenis_pemesanan' => 'souvenir',
                'tanggal_pemesanan' => $data['tanggal'],
                'total_harga' => $data['total'],
                'status_pemesanan' => $data['status'] === 'lunas' ? 'selesai' : 'menunggu_pembayaran',
            ]);

            // Detail Pemesanan
            DetailPemesanan::create([
                'pemesanan_id' => $pemesanan->pemesanan_id,
                'souvenir_id' => $souvenirRef?->souvenir_id,
                'nama_item' => 'Paket Souvenir Grosir (' . $data['nama'] . ')',
                'harga' => $data['total'] / $data['qty'],
                'jumlah' => $data['qty'],
                'subtotal' => $data['total'],
            ]);

            // Pembayaran
            $pembayaran = Pembayaran::create([
                'pemesanan_id' => $pemesanan->pemesanan_id,
                'metode_pembayaran' => strtolower($data['metode']),
                'jumlah_bayar' => $data['dibayar'],
                'tanggal_pembayaran' => $data['tanggal'],
                'status_pembayaran' => $data['status'] === 'lunas' ? 'disetujui' : 'menunggu_verifikasi',
                'catatan_admin' => 'Data offline awal sebelum migrasi web.',
                'verified_at' => $data['status'] === 'lunas' ? $data['tanggal'] : null,
                'verified_by' => $data['status'] === 'lunas' ? $adminId : null,
            ]);

            // Invoice
            Invoice::create([
                'pemesanan_id' => $pemesanan->pemesanan_id,
                'pembayaran_id' => $pembayaran->pembayaran_id,
                'nomor_invoice' => 'INV-' . date('Ymd', strtotime($data['tanggal'])) . '-S' . str_pad($idx + 1, 3, '0', STR_PAD_LEFT),
                'tanggal_invoice' => $data['tanggal'],
                'total_tagihan' => $data['total'],
                'status_invoice' => $data['status'] === 'lunas' ? 'lunas' : 'terbit',
            ]);
        }


        // --- 2. SEED DATA OFFLINE HOMESTAY (MARET 2026) ---
        $homestaysOffline = [
            // 24 Maret 2026
            ['tanggal' => '2026-03-24 12:00:00', 'nominal' => 450000, 'metode' => 'Cash'],
            ['tanggal' => '2026-03-24 13:00:00', 'nominal' => 400000, 'metode' => 'Transfer'],
            ['tanggal' => '2026-03-24 14:00:00', 'nominal' => 400000, 'metode' => 'Cash'],
            ['tanggal' => '2026-03-24 15:00:00', 'nominal' => 400000, 'metode' => 'Cash'],

            // 25 Maret 2026
            ['tanggal' => '2026-03-25 11:00:00', 'nominal' => 350000, 'metode' => 'Cash'],
            ['tanggal' => '2026-03-25 12:00:00', 'nominal' => 350000, 'metode' => 'Cash'],
            ['tanggal' => '2026-03-25 13:00:00', 'nominal' => 400000, 'metode' => 'Cash'],
            ['tanggal' => '2026-03-25 14:00:00', 'nominal' => 400000, 'metode' => 'Cash'],

            // 26 Maret 2026
            ['tanggal' => '2026-03-26 10:00:00', 'nominal' => 350000, 'metode' => 'Transfer'],
            ['tanggal' => '2026-03-26 12:00:00', 'nominal' => 800000, 'metode' => 'Cash'],
            ['tanggal' => '2026-03-26 14:00:00', 'nominal' => 400000, 'metode' => 'Cash'],
            ['tanggal' => '2026-03-26 16:00:00', 'nominal' => 500000, 'metode' => 'Cash'],

            // 27 Maret 2026
            ['tanggal' => '2026-03-27 11:00:00', 'nominal' => 350000, 'metode' => 'Cash'],
            ['tanggal' => '2026-03-27 13:00:00', 'nominal' => 350000, 'metode' => 'Cash'],
        ];

        // Ambil homestay id acak sebagai referensi
        $homestayRef = Homestay::first();

        // Buat user dummy khusus pembeli homestay offline
        $userHomestay = User::firstOrCreate(
            ['email' => 'tamu.offline@gmail.com'],
            [
                'nama' => 'Tamu Offline Homestay',
                'password' => 'password123',
                'no_hp' => '080000000099',
                'alamat' => 'Booking Offline',
                'role' => 'user',
                'email_verified_at' => now(),
            ]
        );

        foreach ($homestaysOffline as $idx => $data) {
            // Buat Pemesanan
            $pemesanan = Pemesanan::create([
                'user_id' => $userHomestay->user_id,
                'kode_pemesanan' => 'PMS-OFFLINE-H' . str_pad($idx + 1, 3, '0', STR_PAD_LEFT),
                'jenis_pemesanan' => 'homestay',
                'tanggal_pemesanan' => $data['tanggal'],
                'total_harga' => $data['nominal'],
                'status_pemesanan' => 'selesai',
            ]);

            // Detail Pemesanan (Check-in disamakan dengan tanggal pemesanan)
            $checkIn = date('Y-m-d', strtotime($data['tanggal']));
            $checkOut = date('Y-m-d', strtotime($data['tanggal'] . ' + 1 day'));

            DetailPemesanan::create([
                'pemesanan_id' => $pemesanan->pemesanan_id,
                'homestay_id' => $homestayRef?->homestay_id,
                'nama_item' => $homestayRef?->nama_homestay ?? 'Sewa Kamar Homestay',
                'harga' => $data['nominal'],
                'jumlah' => 1,
                'check_in' => $checkIn,
                'check_out' => $checkOut,
                'jumlah_malam' => 1,
                'subtotal' => $data['nominal'],
            ]);

            // Pembayaran
            $pembayaran = Pembayaran::create([
                'pemesanan_id' => $pemesanan->pemesanan_id,
                'metode_pembayaran' => strtolower($data['metode']),
                'jumlah_bayar' => $data['nominal'],
                'tanggal_pembayaran' => $data['tanggal'],
                'status_pembayaran' => 'disetujui',
                'catatan_admin' => 'Data offline homestay Maret.',
                'verified_at' => $data['tanggal'],
                'verified_by' => $adminId,
            ]);

            // Invoice
            Invoice::create([
                'pemesanan_id' => $pemesanan->pemesanan_id,
                'pembayaran_id' => $pembayaran->pembayaran_id,
                'nomor_invoice' => 'INV-' . date('Ymd', strtotime($data['tanggal'])) . '-H' . str_pad($idx + 1, 3, '0', STR_PAD_LEFT),
                'tanggal_invoice' => $data['tanggal'],
                'total_tagihan' => $data['nominal'],
                'status_invoice' => 'lunas',
            ]);
        }
    }
}
