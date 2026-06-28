# Sistem Informasi Homestay dan Suvenir (SIMHOSUV)

![Laravel](https://img.shields.io/badge/Laravel-13.8+-FF2D20?logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.3+-777BB4?logo=php&logoColor=white)
![Blade](https://img.shields.io/badge/Blade-Laravel%20Blade-FF2D20)
![Tailwind](https://img.shields.io/badge/TailwindCSS-4.2+-38BDF8?logo=tailwindcss&logoColor=white)
![Status](https://img.shields.io/badge/Status-Dalam%20Pengembangan-F2C94C)

Sistem Informasi Manajmen Homestay dan Penjualan Souvenir Berbasis WEB Pada Natasya Homestay dan Harau Souvenir merupakan aplikasi berbasis web yang dirancang untuk membantu pengelolaan usaha homestay dan penjualan suvenir secara terintegrasi. Sistem ini memungkinkan pelanggan melakukan reservasi homestay, pembelian suvenir, pengelolaan pembayaran, serta membantu pengelola dalam mengelola operasional dan laporan usaha.

> **Status implementasi:** Saat ini proyek telah memiliki autentikasi pengguna, middleware role admin/user, manajemen profil, dashboard admin berbasis data database, CRUD kategori homestay, CRUD homestay, CRUD suvenir, katalog pelanggan, keranjang belanja, halaman checkout awal, seeder, CI dasar, dan test feature untuk modul utama yang sudah berjalan. Alur pemesanan, pembayaran, invoice, reservasi, laporan, ulasan, dan payment gateway masih menjadi backlog sprint berikutnya.

---

## Deskripsi Proyek

Pengelolaan homestay dan penjualan suvenir secara manual sering menimbulkan berbagai kendala, seperti pencatatan reservasi yang kurang terorganisir, pengelolaan stok yang tidak terpantau dengan baik, serta kesulitan dalam penyusunan laporan usaha.

Melalui Sistem Informasi Manajmen Homestay dan Penjualan Souvenir Berbasis WEB Pada Natasya Homestay dan Harau Souvenir, proses bisnis dapat dilakukan secara lebih efektif dan terintegrasi sehingga meningkatkan kualitas layanan bagi pelanggan serta mempermudah pengelolaan usaha.

### Tujuan Sistem

- Menyediakan informasi homestay dan suvenir secara online.
- Memudahkan pelanggan melakukan reservasi homestay.
- Memudahkan pelanggan melakukan pembelian suvenir.
- Membantu admin dalam mengelola data usaha.
- Menyediakan laporan transaksi dan statistik usaha bagi owner.

---

## Aktor Sistem

| Aktor      | Tanggung Jawab Utama                                                                                            |
| ---------- | --------------------------------------------------------------------------------------------------------------- |
| Pengunjung | Melihat informasi homestay, katalog suvenir, galeri, dan informasi umum tanpa login.                            |
| Customer   | Registrasi, login, melakukan reservasi homestay, pembelian suvenir, pembayaran, serta melihat status transaksi. |
| Admin      | Mengelola homestay, kamar, fasilitas, suvenir, transaksi, pembayaran, dan data pengguna.                        |
| Owner      | Mengakses laporan dan statistik usaha.                                                                          |

---

## Fitur Sistem

### Fitur Publik

| Fitur              | Status       |
| ------------------ | ------------ |
| Homepage           | Direncanakan |
| Informasi Homestay | Tersedia untuk user login |
| Katalog Suvenir    | Tersedia untuk user login |
| Galeri             | Direncanakan |
| Informasi Kontak   | Direncanakan |
| Pencarian Homestay | Direncanakan |

### Fitur Customer

| Fitur                   | Status           |
| ----------------------- | ---------------- |
| Login dan Registrasi    | Tersedia         |
| Manajemen Profil        | Tersedia         |
| Reservasi Homestay      | Direncanakan     |
| Pembelian Suvenir       | Keranjang tersedia, pemesanan belum |
| Checkout dan Pembayaran | Checkout awal tersedia, pembayaran belum |
| Riwayat Transaksi       | Direncanakan     |
| Ulasan Homestay         | Direncanakan     |

### Fitur Operasional dan Manajerial

| Fitur                 | Status           |
| --------------------- | ---------------- |
| Dashboard Dasar       | Tersedia dengan statistik database |
| Manajemen Homestay    | Tersedia         |
| Manajemen Kamar       | Direncanakan     |
| Manajemen Fasilitas   | Direncanakan     |
| Manajemen Suvenir     | Tersedia         |
| Manajemen Stok        | Tersedia pada CRUD suvenir |
| Verifikasi Pembayaran | Direncanakan     |
| Manajemen Transaksi   | Direncanakan     |
| Laporan dan Statistik | Direncanakan     |

---

## Aturan Bisnis Utama

1. Pengunjung dapat melihat informasi homestay dan suvenir tanpa login.
2. Customer wajib login sebelum melakukan reservasi homestay atau pembelian suvenir.
3. Reservasi hanya dapat dilakukan pada kamar yang tersedia pada tanggal yang dipilih.
4. Pembayaran harus diverifikasi sebelum reservasi atau pesanan diproses.
5. Stok suvenir akan berkurang secara otomatis setelah transaksi berhasil.
6. Customer dapat melihat status transaksi melalui dashboard.
7. Owner hanya memiliki akses terhadap laporan dan statistik usaha.

---

## Teknologi yang Digunakan

| Komponen          | Teknologi                     |
| ----------------- | ----------------------------- |
| Backend Framework | Laravel 13                    |
| Bahasa Backend    | PHP 8.3                       |
| Frontend          | Laravel Blade                 |
| Styling           | Tailwind CSS 4                |
| Build Tool        | Vite                          |
| Authentication    | Custom Authentication Laravel |
| Database          | MySQL                         |
| Testing           | Pest dan PHPUnit              |
| Code Formatter    | Laravel Pint                  |
| Version Control   | Git & GitHub                  |

---

## Instalasi Singkat

### 1. Clone Repository

```bash
git https://github.com/xayy28/pentathree-app.git
cd pentathree-app
```

### 2. Install Dependency

```bash
composer install
npm install
```

### 3. Konfigurasi Environment

Salin file `.env.example` menjadi `.env`.

**Windows PowerShell**

```powershell
Copy-Item .env.example .env
```

**Linux / macOS**

```bash
cp .env.example .env
```

Generate application key:

```bash
php artisan key:generate
```

### 4. Konfigurasi Database

Buat database MySQL terlebih dahulu, kemudian sesuaikan konfigurasi database pada file `.env`.

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pentathree_app
DB_USERNAME=root
DB_PASSWORD=
```

Jalankan migrasi database:

```bash
php artisan migrate
```

Jika menggunakan seeder:

```bash
php artisan migrate --seed
```

### 5. Menjalankan Aplikasi

Jalankan server Laravel:

```bash
php artisan serve
```

Jalankan Vite:

```bash
npm run dev
```

Aplikasi dapat diakses melalui:

```text
http://127.0.0.1:8000
```

---

## Struktur Project

```text
SIMHOSUV/
├── app/
├── bootstrap/
├── config/
├── database/
│   ├── migrations/
│   └── seeders/
├── public/
├── resources/
│   ├── views/
│   ├── css/
│   └── js/
├── routes/
├── storage/
├── tests/
├── docs/
├── README.md
└── CHANGELOG.md
```

---

## Dokumentasi Proyek

| Dokumen                | Keterangan                               |
| ---------------------- | ---------------------------------------- |
| docs/instalation.md    | Panduan instalasi dan konfigurasi sistem |
| docs/dependency.md     | Daftar dependency yang digunakan         |
| docs/refactoring.md    | Riwayat refactoring proyek               |
| docs/github-actions.md | Dokumentasi CI/CD dan GitHub Actions     |

---

## Modul Utama Sistem

### Modul Homestay

- Manajemen Homestay
- Manajemen Kamar
- Manajemen Fasilitas
- Reservasi Homestay
- Monitoring Ketersediaan Kamar

### Modul Suvenir

- Manajemen Produk
- Manajemen Kategori
- Manajemen Stok
- Pemesanan Suvenir

### Modul Transaksi

- Checkout
- Pembayaran
- Verifikasi Pembayaran
- Riwayat Transaksi

### Modul Laporan

- Laporan Reservasi Homestay
- Laporan Penjualan Suvenir
- Statistik Pendapatan
- Rekapitulasi Transaksi

---

## Screenshot

Screenshot aktual akan ditambahkan setelah fitur utama selesai diimplementasikan.

| Halaman            | Status                      |
| ------------------ | --------------------------- |
| Login & Registrasi | Tersedia                    |
| Dashboard          | Tersedia                    |
| Daftar Homestay    | Tersedia                    |
| Detail Homestay    | Menunggu Implementasi       |
| Katalog Suvenir    | Tersedia                    |
| Checkout           | Tampilan awal tersedia      |
| Laporan            | Menunggu Implementasi       |

---

## Tim Pengembang — Kelompok PentaThree

| Nama                   | Peran             |
| ---------------------- | ----------------- |
| Zackri Kurnia Amri     | Project Manager   |
| Yelsa Pagansa Putri    | Lead Programmer   |
| Zikri Ilham Pratama    | Lead Programmer   |
| Muhammad Aufi Syahyudi | System Analyst    |
| Taufiqurrahman         | Quality Assurance |

---

## Status Akademik

Proyek ini dikembangkan untuk memenuhi tugas **Project Based Learning (PBL)** pada mata kuliah **Konstruksi dan Evolusi Perangkat Lunak**, Program Studi **D4 Teknologi Rekayasa Perangkat Lunak**, Jurusan **Teknologi Informasi**, **Politeknik Negeri Padang**.

---

## Lisensi

Proyek ini dikembangkan untuk tujuan akademik dan pembelajaran. Seluruh kode sumber dalam repository ini digunakan sebagai bagian dari kegiatan Project Based Learning (PBL).
