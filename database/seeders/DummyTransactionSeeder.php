<?php

namespace Database\Seeders;

use App\Models\DetailPemesanan;
use App\Models\Homestay;
use App\Models\Invoice;
use App\Models\Pembayaran;
use App\Models\Pemesanan;
use App\Models\Souvenir;
use App\Models\Ulasan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DummyTransactionSeeder extends Seeder
{
    private array $homestayReviews = [
        'Kamar sangat nyaman dan bersih. Pelayanan ramah. Sangat recommended untuk liburan keluarga!',
        'Lokasi strategis, mudah dijangkau. Fasilitas lengkap dengan harga terjangkau.',
        'Kamar cukup luas, cocok untuk rombongan. Sarapan yang disediakan enak dan variatif.',
        'Suasana tenang dan nyaman. Cocok untuk liburan keluarga. Anak-anak betah.',
        'Pelayanan memuaskan. Kamar bersih dan rapi. AC dingin, tidur nyenyak.',
        'Harga sesuai dengan kualitas yang didapat. Akan kembali lagi lain waktu.',
        'Fasilitas lengkap, kamar bersih. Puas menginap di sini. WiFi juga kencang.',
        'Pemandangan indah dari jendela kamar. Pengalaman menginap yang menyenangkan.',
        'Kamar standar tapi nyaman. Kamar mandi dalam bersih. Recommended!',
        'Sangat puas dengan pelayanan. Kamar bersih, handuk tersedia. Top!',
        'Lokasi dekat dengan objek wisata Lembah Harau. Kamar nyaman.',
        'Pelayanan luar biasa. Fasilitas lengkap dan modern. Worth it!',
        'Cocok untuk liburan keluarga besar. Kamar luas dan fasilitas lengkap.',
        'Suasana pedesaan yang asri. Tidur nyenyak semalam suntuk.',
        'Kamar bersih, handuk dan sabun tersedia. Pelayanan top!',
    ];

    private array $souvenirReviews = [
        'Souvenir cantik, kualitas bahan bagus. Puas dengan pembelian ini!',
        'Pengemasan rapi, barang sesuai foto. Kualitas premium.',
        'Bahan premium, jahitan rapi. Worth it dengan harga yang ditawarkan.',
        'Motifnya cantik, warnanya sesuai. Sangat recommended!',
        'Souvenir unik dan berkualitas. Cocok untuk hadiah.',
        'Kualitas oke, harga reasonable. Suka dengan desainnya.',
        'Bahan nyaman dipakai, desain menarik. Repeat order!',
        'Barang sesuai deskripsi, packaging aman. Tidak ada cacat.',
        'Souvenir khas Harau yang bagus. Kualitas terjamin.',
        'Jahitan kuat, bahan tebal. Tahan lama dipakai.',
        'Motif daun tropisnya cantik banget! Suka sekali.',
        'Tasnya muat banyak, bahan kuat. Praktis untuk sehari-hari.',
        'Setelannya lucu, anak saya suka. Bahan adem dan nyaman.',
        'Kualitas jahitan premium, warna tidak luntur setelah dicuci.',
        'Pengiriman cepat, barang sampai dengan selamat. Terima kasih!',
        'Tas selempangnya imut, cocok untuk jalan-jalan.',
        'Handbag-nya elegan, muat banyak barang. Suka!',
        'Bahan tote bag tebal, jahitan kuat. Sangat memuaskan.',
        'Celana pendeknya nyaman dipakai, bahan adem.',
        'Stelan anak lucu, bahannya lembut. Anak betah memakainya.',
    ];

    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();
        if (! $admin) {
            return;
        }

        $customers = $this->createCustomers();
        $homestays = Homestay::all()->toArray();
        $souvenirs = Souvenir::all()->toArray();

        if (empty($homestays) || empty($souvenirs)) {
            return;
        }

        $completed = [];
        $completed = array_merge(
            $completed,
            $this->seedSouvenirTransactions($customers, $souvenirs, $admin->user_id),
            $this->seedHomestayTransactions($customers, $homestays, $admin->user_id),
        );

        $this->seedUlasans($completed);
    }

    private function createCustomers(): array
    {
        $data = [
            ['Andi Saputra', 'andi.saputra@gmail.com', '081234560001', 'Padang, Sumatera Barat'],
            ['Rina Wati', 'rina.wati@gmail.com', '081234560002', 'Bukittinggi, Sumatera Barat'],
            ['Budi Santoso', 'budi.santoso@gmail.com', '081234560003', 'Jakarta Selatan, DKI Jakarta'],
            ['Dewi Lestari', 'dewi.lestari@gmail.com', '081234560004', 'Bandung, Jawa Barat'],
            ['Farhan Hakim', 'farhan.hakim@gmail.com', '081234560005', 'Surabaya, Jawa Timur'],
            ['Gita Puspita', 'gita.puspita@gmail.com', '081234560006', 'Yogyakarta'],
            ['Hendra Kusuma', 'hendra.kusuma@gmail.com', '081234560007', 'Medan, Sumatera Utara'],
            ['Indah Permata', 'indah.permata@gmail.com', '081234560008', 'Palembang, Sumatera Selatan'],
            ['Joko Prasetyo', 'joko.prasetyo@gmail.com', '081234560009', 'Semarang, Jawa Tengah'],
            ['Kartika Sari', 'kartika.sari@gmail.com', '081234560010', 'Malang, Jawa Timur'],
            ['Luthfi Ramadhan', 'luthfi.r@gmail.com', '081234560011', 'Pekanbaru, Riau'],
            ['Maya Anggraeni', 'maya.anggraeni@gmail.com', '081234560012', 'Bekasi, Jawa Barat'],
            ['Nanda Pratama', 'nanda.pratama@gmail.com', '081234560013', 'Tangerang, Banten'],
            ['Omar Fauzan', 'omar.fauzan@gmail.com', '081234560014', 'Depok, Jawa Barat'],
            ['Putri Rahayu', 'putri.rahayu@gmail.com', '081234560015', 'Solo, Jawa Tengah'],
            ['Rizky Aditya', 'rizky.aditya@gmail.com', '081234560016', 'Bogor, Jawa Barat'],
            ['Sinta Dewi', 'sinta.dewi@gmail.com', '081234560017', 'Bandar Lampung, Lampung'],
            ['Tono Sugiarto', 'tono.sugiarto@gmail.com', '081234560018', 'Jember, Jawa Timur'],
            ['Vina Oktaviani', 'vina.oktaviani@gmail.com', '081234560019', 'Cirebon, Jawa Barat'],
            ['Wahyu Nugroho', 'wahyu.nugroho@gmail.com', '081234560020', 'Pontianak, Kalimantan Barat'],
        ];

        $users = [];
        foreach ($data as [$nama, $email, $no_hp, $alamat]) {
            $users[] = User::firstOrCreate(
                ['email' => $email],
                [
                    'nama' => $nama,
                    'password' => 'password123',
                    'no_hp' => $no_hp,
                    'alamat' => $alamat,
                    'role' => 'user',
                    'email_verified_at' => now(),
                ]
            );
        }

        return $users;
    }

    private function seedSouvenirTransactions(array $customers, array $souvenirs, string $adminId): array
    {
        $completed = [];
        $custCount = count($customers);

        // Phase 1: One transaction per souvenir (all 34 souvenirs, all verified/selesai)
        foreach ($souvenirs as $idx => $souvenir) {
            $customer = $customers[$idx % $custCount];
            $qty = ($idx % 5) + 1;
            $total = $souvenir['harga'] * $qty;
            $date = Carbon::create(2026, ($idx % 5) + 1, ($idx % 28) + 1, 9 + ($idx % 9), ($idx * 7) % 60);

            $pemesanan = Pemesanan::create([
                'user_id' => $customer->user_id,
                'jenis_pemesanan' => Pemesanan::JENIS_SOUVENIR,
                'tanggal_pemesanan' => $date,
                'total_harga' => $total,
                'status_pemesanan' => Pemesanan::STATUS_SELESAI,
            ]);

            $detail = DetailPemesanan::create([
                'pemesanan_id' => $pemesanan->pemesanan_id,
                'souvenir_id' => $souvenir['souvenir_id'],
                'nama_item' => $souvenir['nama_souvenir'],
                'harga' => $souvenir['harga'],
                'jumlah' => $qty,
                'subtotal' => $total,
            ]);

            $verifiedAt = $date->copy()->addHours(rand(1, 24));

            $pembayaran = Pembayaran::create([
                'pemesanan_id' => $pemesanan->pemesanan_id,
                'metode_pembayaran' => 'transfer',
                'jumlah_bayar' => $total,
                'tanggal_pembayaran' => $date,
                'status_pembayaran' => Pembayaran::STATUS_TERVERIFIKASI,
                'catatan_admin' => 'Pembayaran dummy untuk demo.',
                'verified_at' => $verifiedAt,
                'verified_by' => $adminId,
            ]);

            Invoice::create([
                'pemesanan_id' => $pemesanan->pemesanan_id,
                'pembayaran_id' => $pembayaran->pembayaran_id,
                'tanggal_invoice' => $verifiedAt,
                'total_tagihan' => $total,
                'status_invoice' => Invoice::STATUS_TERBIT,
            ]);

            $souvenirModel = Souvenir::find($souvenir['souvenir_id']);
            $souvenirModel->decrement('stok', $qty);
            $souvenirModel->increment('jumlah_terjual', $qty);

            $completed[] = ['pemesanan' => $pemesanan, 'detail' => $detail, 'type' => 'souvenir'];
        }

        // Phase 2: Multi-item orders (16 orders, mixed statuses)
        $multiOrders = [
            // [souvenir_indices, customer_idx, pemesanan_status, payment_status, has_invoice]
            [[0, 1, 2], 0, Pemesanan::STATUS_SELESAI, Pembayaran::STATUS_TERVERIFIKASI, true],
            [[3, 4], 1, Pemesanan::STATUS_SELESAI, Pembayaran::STATUS_TERVERIFIKASI, true],
            [[5, 6, 7], 2, Pemesanan::STATUS_TERVERIFIKASI, Pembayaran::STATUS_TERVERIFIKASI, true],
            [[8, 9], 3, Pemesanan::STATUS_MENUNGGU_VERIFIKASI, Pembayaran::STATUS_MENUNGGU_VERIFIKASI, false],
            [[10, 11, 12], 4, Pemesanan::STATUS_SELESAI, Pembayaran::STATUS_TERVERIFIKASI, true],
            [[13, 14], 5, Pemesanan::STATUS_MENUNGGU_PEMBAYARAN, null, false],
            [[15, 16, 17], 6, Pemesanan::STATUS_SELESAI, Pembayaran::STATUS_TERVERIFIKASI, true],
            [[18, 19], 7, Pemesanan::STATUS_DIBATALKAN, null, false],
            [[20, 21, 22], 8, Pemesanan::STATUS_SELESAI, Pembayaran::STATUS_TERVERIFIKASI, true],
            [[23, 24], 9, Pemesanan::STATUS_MENUNGGU_VERIFIKASI, Pembayaran::STATUS_MENUNGGU_VERIFIKASI, false],
            [[25, 26, 27], 10, Pemesanan::STATUS_TERVERIFIKASI, Pembayaran::STATUS_TERVERIFIKASI, true],
            [[28, 29], 11, Pemesanan::STATUS_SELESAI, Pembayaran::STATUS_TERVERIFIKASI, true],
            [[30, 31, 32], 12, Pemesanan::STATUS_DIBATALKAN, null, false],
            [[33, 0], 13, Pemesanan::STATUS_MENUNGGU_PEMBAYARAN, null, false],
            [[2, 5, 8], 14, Pemesanan::STATUS_SELESAI, Pembayaran::STATUS_TERVERIFIKASI, true],
            [[11, 14, 17], 15, Pemesanan::STATUS_MENUNGGU_VERIFIKASI, Pembayaran::STATUS_MENUNGGU_VERIFIKASI, false],
        ];

        foreach ($multiOrders as $orderIdx => [$souvenirIndices, $custIdx, $pStatus, $payStatus, $hasInvoice]) {
            $customer = $customers[$custIdx % $custCount];
            $date = Carbon::create(2026, ($orderIdx % 5) + 2, ($orderIdx % 28) + 1, 10 + ($orderIdx % 7), ($orderIdx * 13) % 60);

            // Calculate total first
            $totalHarga = 0;
            $detailData = [];
            foreach ($souvenirIndices as $sIdx) {
                $s = $souvenirs[$sIdx];
                $qty = ($orderIdx % 3) + 1;
                $subtotal = $s['harga'] * $qty;
                $totalHarga += $subtotal;
                $detailData[] = [
                    'souvenir_id' => $s['souvenir_id'],
                    'nama_item' => $s['nama_souvenir'],
                    'harga' => $s['harga'],
                    'jumlah' => $qty,
                    'subtotal' => $subtotal,
                ];
            }

            $pemesanan = Pemesanan::create([
                'user_id' => $customer->user_id,
                'jenis_pemesanan' => Pemesanan::JENIS_SOUVENIR,
                'tanggal_pemesanan' => $date,
                'total_harga' => $totalHarga,
                'status_pemesanan' => $pStatus,
            ]);

            $detailModels = [];
            foreach ($detailData as $d) {
                $d['pemesanan_id'] = $pemesanan->pemesanan_id;
                $detailModels[] = DetailPemesanan::create($d);
            }

            $firstDetail = $detailModels[0];

            if ($payStatus) {
                $verifiedAt = in_array($payStatus, [Pembayaran::STATUS_TERVERIFIKASI])
                    ? $date->copy()->addHours(rand(1, 48))
                    : null;

                $pembayaran = Pembayaran::create([
                    'pemesanan_id' => $pemesanan->pemesanan_id,
                    'metode_pembayaran' => 'transfer',
                    'jumlah_bayar' => $totalHarga,
                    'tanggal_pembayaran' => $date,
                    'status_pembayaran' => $payStatus,
                    'catatan_admin' => $payStatus === Pembayaran::STATUS_TERVERIFIKASI
                        ? 'Pembayaran dummy untuk demo.'
                        : null,
                    'verified_at' => $verifiedAt,
                    'verified_by' => $verifiedAt ? $adminId : null,
                ]);

                if ($hasInvoice && $verifiedAt) {
                    Invoice::create([
                        'pemesanan_id' => $pemesanan->pemesanan_id,
                        'pembayaran_id' => $pembayaran->pembayaran_id,
                        'tanggal_invoice' => $verifiedAt,
                        'total_tagihan' => $totalHarga,
                        'status_invoice' => Invoice::STATUS_TERBIT,
                    ]);
                }
            }

            if ($pStatus === Pemesanan::STATUS_SELESAI) {
                foreach ($detailData as $d) {
                    $souvenirModel = Souvenir::find($d['souvenir_id']);
                    $souvenirModel->decrement('stok', $d['jumlah']);
                    $souvenirModel->increment('jumlah_terjual', $d['jumlah']);
                }

                $completed[] = ['pemesanan' => $pemesanan, 'detail' => $firstDetail, 'type' => 'souvenir'];
            }
        }

        return $completed;
    }

    private function seedHomestayTransactions(array $customers, array $homestays, string $adminId): array
    {
        $completed = [];
        $custCount = count($customers);

        // 7 bookings per homestay = 28 total, various statuses
        $bookings = [
            // Kamar 101 (index 0)
            [0, 0, '2026-01-05', '2026-01-07', 2, Pemesanan::STATUS_SELESAI, Pembayaran::STATUS_TERVERIFIKASI],
            [0, 1, '2026-01-20', '2026-01-23', 3, Pemesanan::STATUS_SELESAI, Pembayaran::STATUS_TERVERIFIKASI],
            [0, 2, '2026-02-10', '2026-02-12', 2, Pemesanan::STATUS_SELESAI, Pembayaran::STATUS_TERVERIFIKASI],
            [0, 3, '2026-03-01', '2026-03-03', 2, Pemesanan::STATUS_SEDANG_MENGINAP, Pembayaran::STATUS_TERVERIFIKASI],
            [0, 4, '2026-03-15', '2026-03-17', 2, Pemesanan::STATUS_DIKONFIRMASI, Pembayaran::STATUS_TERVERIFIKASI],
            [0, 5, '2026-04-10', '2026-04-12', 2, Pemesanan::STATUS_MENUNGGU_VERIFIKASI, Pembayaran::STATUS_MENUNGGU_VERIFIKASI],
            [0, 6, '2026-05-01', '2026-05-03', 2, Pemesanan::STATUS_DIBATALKAN, null],

            // Kamar 102 (index 1)
            [1, 7, '2026-01-10', '2026-01-12', 2, Pemesanan::STATUS_SELESAI, Pembayaran::STATUS_TERVERIFIKASI],
            [1, 8, '2026-01-25', '2026-01-28', 3, Pemesanan::STATUS_SELESAI, Pembayaran::STATUS_TERVERIFIKASI],
            [1, 9, '2026-02-15', '2026-02-17', 2, Pemesanan::STATUS_SELESAI, Pembayaran::STATUS_TERVERIFIKASI],
            [1, 10, '2026-03-05', '2026-03-07', 2, Pemesanan::STATUS_SEDANG_MENGINAP, Pembayaran::STATUS_TERVERIFIKASI],
            [1, 11, '2026-04-01', '2026-04-03', 2, Pemesanan::STATUS_DIKONFIRMASI, Pembayaran::STATUS_TERVERIFIKASI],
            [1, 12, '2026-04-20', '2026-04-22', 2, Pemesanan::STATUS_MENUNGGU_VERIFIKASI, Pembayaran::STATUS_MENUNGGU_VERIFIKASI],
            [1, 13, '2026-05-10', '2026-05-12', 2, Pemesanan::STATUS_DIBATALKAN, null],

            // Kamar 201 (index 2)
            [2, 14, '2026-01-15', '2026-01-17', 2, Pemesanan::STATUS_SELESAI, Pembayaran::STATUS_TERVERIFIKASI],
            [2, 15, '2026-02-01', '2026-02-04', 3, Pemesanan::STATUS_SELESAI, Pembayaran::STATUS_TERVERIFIKASI],
            [2, 16, '2026-02-20', '2026-02-22', 2, Pemesanan::STATUS_SELESAI, Pembayaran::STATUS_TERVERIFIKASI],
            [2, 17, '2026-03-10', '2026-03-13', 3, Pemesanan::STATUS_SEDANG_MENGINAP, Pembayaran::STATUS_TERVERIFIKASI],
            [2, 18, '2026-04-05', '2026-04-07', 2, Pemesanan::STATUS_DIKONFIRMASI, Pembayaran::STATUS_TERVERIFIKASI],
            [2, 19, '2026-04-25', '2026-04-27', 2, Pemesanan::STATUS_MENUNGGU_VERIFIKASI, Pembayaran::STATUS_MENUNGGU_VERIFIKASI],
            [2, 0, '2026-05-15', '2026-05-17', 2, Pemesanan::STATUS_DIBATALKAN, null],

            // Kamar 202 (index 3)
            [3, 1, '2026-01-20', '2026-01-22', 2, Pemesanan::STATUS_SELESAI, Pembayaran::STATUS_TERVERIFIKASI],
            [3, 2, '2026-02-05', '2026-02-08', 3, Pemesanan::STATUS_SELESAI, Pembayaran::STATUS_TERVERIFIKASI],
            [3, 3, '2026-02-25', '2026-02-27', 2, Pemesanan::STATUS_SELESAI, Pembayaran::STATUS_TERVERIFIKASI],
            [3, 4, '2026-03-15', '2026-03-17', 2, Pemesanan::STATUS_SEDANG_MENGINAP, Pembayaran::STATUS_TERVERIFIKASI],
            [3, 5, '2026-04-10', '2026-04-12', 2, Pemesanan::STATUS_DIKONFIRMASI, Pembayaran::STATUS_TERVERIFIKASI],
            [3, 6, '2026-05-01', '2026-05-03', 2, Pemesanan::STATUS_MENUNGGU_VERIFIKASI, Pembayaran::STATUS_MENUNGGU_VERIFIKASI],
            [3, 7, '2026-05-20', '2026-05-22', 2, Pemesanan::STATUS_DIBATALKAN, null],
        ];

        foreach ($bookings as [$homestayIdx, $custIdx, $checkInStr, $checkOutStr, $nights, $pStatus, $payStatus]) {
            $customer = $customers[$custIdx % $custCount];
            $homestay = $homestays[$homestayIdx];
            $date = Carbon::parse($checkInStr)->subDays(rand(1, 7))->setTime(10 + ($homestayIdx * 3 + $custIdx) % 8, ($custIdx * 17) % 60);
            $total = $homestay['harga_permalam'] * $nights;

            $pemesanan = Pemesanan::create([
                'user_id' => $customer->user_id,
                'jenis_pemesanan' => Pemesanan::JENIS_HOMESTAY,
                'tanggal_pemesanan' => $date,
                'total_harga' => $total,
                'status_pemesanan' => $pStatus,
            ]);

            $detail = DetailPemesanan::create([
                'pemesanan_id' => $pemesanan->pemesanan_id,
                'homestay_id' => $homestay['homestay_id'],
                'nama_item' => $homestay['nama_homestay'],
                'harga' => $homestay['harga_permalam'],
                'jumlah' => 1,
                'check_in' => $checkInStr,
                'check_out' => $checkOutStr,
                'jumlah_malam' => $nights,
                'subtotal' => $total,
            ]);

            if ($payStatus) {
                $verifiedAt = $payStatus === Pembayaran::STATUS_TERVERIFIKASI
                    ? $date->copy()->addHours(rand(1, 48))
                    : null;

                $pembayaran = Pembayaran::create([
                    'pemesanan_id' => $pemesanan->pemesanan_id,
                    'metode_pembayaran' => 'transfer',
                    'jumlah_bayar' => $total,
                    'tanggal_pembayaran' => $date,
                    'status_pembayaran' => $payStatus,
                    'catatan_admin' => $payStatus === Pembayaran::STATUS_TERVERIFIKASI
                        ? 'Pembayaran homestay dummy untuk demo.'
                        : null,
                    'verified_at' => $verifiedAt,
                    'verified_by' => $verifiedAt ? $adminId : null,
                ]);

                if ($verifiedAt) {
                    Invoice::create([
                        'pemesanan_id' => $pemesanan->pemesanan_id,
                        'pembayaran_id' => $pembayaran->pembayaran_id,
                        'tanggal_invoice' => $verifiedAt,
                        'total_tagihan' => $total,
                        'status_invoice' => Invoice::STATUS_TERBIT,
                    ]);
                }
            }

            if ($pStatus === Pemesanan::STATUS_SELESAI) {
                $completed[] = ['pemesanan' => $pemesanan, 'detail' => $detail, 'type' => 'homestay'];
            }
        }

        return $completed;
    }

    private function seedUlasans(array $completedPemesanans): void
    {
        foreach ($completedPemesanans as $item) {
            $pemesanan = $item['pemesanan'];
            $detail = $item['detail'];
            $type = $item['type'];

            $ulasanData = [
                'user_id' => $pemesanan->user_id,
                'pemesanan_id' => $pemesanan->pemesanan_id,
                'detail_pemesanan_id' => $detail->detail_pemesanan_id,
                'rating' => rand(3, 5),
            ];

            if ($type === 'homestay') {
                $ulasanData['homestay_id'] = $detail->homestay_id;
                $ulasanData['komentar'] = $this->homestayReviews[array_rand($this->homestayReviews)];
            } else {
                $ulasanData['souvenir_id'] = $detail->souvenir_id;
                $ulasanData['komentar'] = $this->souvenirReviews[array_rand($this->souvenirReviews)];
            }

            Ulasan::create($ulasanData);
        }
    }
}
