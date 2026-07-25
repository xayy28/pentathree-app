# SIMHOSUV — Sistem Informasi Homestay dan Souvenir

![Laravel](https://img.shields.io/badge/Laravel-13.x-FF2D20?logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.3+-777BB4?logo=php&logoColor=white)
![Midtrans](https://img.shields.io/badge/Midtrans-Sandbox-00AEEF)
![Mailtrap](https://img.shields.io/badge/Mailtrap-SMTP_Sandbox-00D09C)
![Tests](https://img.shields.io/badge/Tests-Passing-2EA44F)

Sistem Informasi Manajemen Homestay dan Penjualan Souvenir Berbasis Web pada **Natasha Homestay & Harau Souvenir**. Aplikasi Laravel untuk pengelolaan homestay, penjualan souvenir, pemesanan, pembayaran (manual + Midtrans), reservasi, invoice, laporan, dan ulasan.

**Sprint terkini:** Sprint 9 — Polish and Optional Scope.

---

## Daftar Isi

- [Fitur Utama](#fitur-utama)
- [Role Pengguna](#role-pengguna)
- [Teknologi](#teknologi)
- [Dependency Utama](#dependency-utama)
- [External Services](#external-services)
- [Persyaratan Sistem](#persyaratan-sistem)
- [Instalasi Cepat](#instalasi-cepat)
- [Konfigurasi](#konfigurasi)
- [Migration dan Seeder](#migration-dan-seeder)
- [Menjalankan Aplikasi](#menjalankan-aplikasi)
- [Akun Demo](#akun-demo)
- [Testing](#testing)
- [Screenshots](#screenshots)
- [Struktur Project](#struktur-project)
- [Dokumentasi](#dokumentasi)
- [Troubleshooting](#troubleshooting)
- [Tim Pengembang](#tim-pengembang)
- [Lisensi](#lisensi)

---

## Fitur Utama

### Publik (Guest)
- Homepage dengan hero, homestay, souvenir, statistik, dan ulasan
- Login, register, lupa password

### Customer
- Dashboard dengan ringkasan
- Katalog homestay + filter + booking (dengan kalender ketersediaan)
- Katalog souvenir + detail + keranjang + checkout
- Pembayaran: **Midtrans Online** (Snap, webhook, fallback) atau **Manual** (transfer_bank, qris_manual, tunai)
- Riwayat pesanan + detail
- Invoice + PDF (DomPDF)
- Ulasan/rating per item
- Manajemen profil + foto
- Email verification (wajib sebelum booking/pembayaran)
- Halaman informasi: FAQ, cara pemesanan, kebijakan privasi, syarat ketentuan

### Admin
- Dashboard dengan statistik komprehensif (pendapatan, tren, popular, dll)
- CRUD: homestay, kategori, fasilitas, souvenir, user
- Manajemen pembayaran (verify/reject/status/complete)
- Manajemen reservasi (status, verify/reject payment)
- Laporan + unduh PDF (filter tanggal)
- Invoice customer view + PDF
- Notifikasi transaksi baru

### Sistem
- Role Spatie Permission + fallback `users.role`
- Payment settlement idempotent (`DB::transaction` + `lockForUpdate`)
- Stok souvenir berkurang sekali saat verifikasi
- Invoice auto-generate (`INV-YYYYMMDD-NNNN`)
- Webhook Midtrans + fallback cek status
- Optimasi upload gambar (WebP, resize via Intervention Image)
- Email via Mailtrap SMTP (verifikasi, reset password)

---

## Role Pengguna

| Role | Hak Akses |
| --- | --- |
| **Admin** | Dashboard, CRUD, pembayaran, reservasi, laporan, invoice, notifikasi |
| **Customer** | Katalog, booking, keranjang, checkout, pembayaran, riwayat, invoice, ulasan, profil |

---

## Teknologi

| Komponen | Teknologi |
| --- | --- |
| Backend Framework | Laravel 13 |
| Bahasa | PHP 8.3+ |
| Frontend | Laravel Blade + Tailwind CSS 4 |
| Build Tool | Vite 8 |
| Database | MySQL |
| Auth | Custom AuthController (email verification) |
| Role | Spatie Laravel Permission 8.1 |
| Payment Gateway | Midtrans Sandbox 2.6 |
| PDF | Laravel DomPDF 3.1 |
| Image Processing | Intervention Image 4.0 |
| Email | Mailtrap SMTP Sandbox |
| Testing | Pest 4.6 + PHPUnit |
| Formatter | Laravel Pint 1.27 |
| CI | GitHub Actions |

---

## Dependency Utama

### Backend (`composer.json`)
| Package | Versi | Fungsi |
| --- | --- | --- |
| `laravel/framework` | ^13.0 | Core framework |
| `spatie/laravel-permission` | ^8.1 | Role dan permission |
| `barryvdh/laravel-dompdf` | ^3.1 | PDF generation |
| `midtrans/midtrans-php` | ^2.6 | Payment gateway SDK |
| `intervention/image-laravel` | ^4.0 | Image optimization |

### Frontend (`package.json`)
| Package | Versi | Fungsi |
| --- | --- | --- |
| `tailwindcss` | ^4.2.4 | CSS framework |
| `vite` | ^8.0.0 | Build tool |
| `laravel-vite-plugin` | ^3.0.0 | Laravel+Vite integration |

---

## External Services

### Mailtrap (Email Sandbox)
Project menggunakan **Mailtrap SMTP Sandbox** untuk mengirim email verifikasi dan reset password saat development/testing.

**Fungsi:**
- Verifikasi email pengguna baru (wajib sebelum akses booking/pembayaran)
- Reset password / lupa password

**Konfigurasi SMTP:**
```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

**Cara mulai:**
1. Daftar di [Mailtrap.io](https://mailtrap.io)
2. Buka Email Testing → buat inbox
3. Salin SMTP credentials ke `.env`
4. Jalankan `php artisan optimize:clear`

### Midtrans (Payment Gateway)
**Fungsi:** Pembayaran online via Snap popup (Sandbox).

**Konfigurasi:**
```env
MIDTRANS_SERVER_KEY=Mid-server-xxxxx
MIDTRANS_CLIENT_KEY=Mid-client-xxxxx
MIDTRANS_IS_PRODUCTION=false
```

---

## Persyaratan Sistem

- PHP 8.3+
- Composer
- Node.js 20+ dan NPM
- MySQL/MariaDB
- Git
- Ekstensi PHP: `pdo_mysql`, `mbstring`, `fileinfo`, `openssl`, `curl`, `gd`, `xml`, `ctype`, `json`

---

## Instalasi Cepat

```bash
# Clone
git clone https://github.com/xayy28/pentathree-app.git
cd pentathree-app

# Install dependency
composer install
npm install

# Setup environment
copy .env.example .env
php artisan key:generate

# Konfigurasi database di .env, lalu:
php artisan migrate --seed
php artisan storage:link

# Jalankan
php artisan serve
npm run dev
```

Akses: `http://127.0.0.1:8000`

---

## Konfigurasi

### Database
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pentathree_app
DB_USERNAME=root
DB_PASSWORD=
```

### Midtrans
```env
MIDTRANS_SERVER_KEY=Mid-server-xxxxx
MIDTRANS_CLIENT_KEY=Mid-client-xxxxx
MIDTRANS_IS_PRODUCTION=false
MIDTRANS_IS_SANITIZED=true
MIDTRANS_IS_3DS=true
```

### Mailtrap
```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

Lihat [docs/instalation.md](docs/instalation.md) untuk panduan lengkap.

---

## Migration dan Seeder

```bash
php artisan migrate --seed
php artisan storage:link
```

---

## Menjalankan Aplikasi

```bash
# Backend
php artisan serve

# Frontend (development)
npm run dev

# Atau sekali jalan
composer run dev
```

---

## Akun Demo

Setelah `php artisan db:seed`:

| Role | Email | Password |
| --- | --- | --- |
| Admin | `admin@aura.com` | `admin123` |
| Customer | `user@aura.com` | `user123` |

---

## Testing

```bash
php artisan test

# Format kode
vendor\bin\pint --dirty

# Build asset
npm run build

# Cek whitespace
git diff --check
```

---

## Screenshots

| Halaman | Preview |
| --- | --- |
| Login | <img src="docs/screenshot/login.png" width="720" alt="Login"> |
| Register | <img src="docs/screenshot/register.png" width="720" alt="Register"> |
| Dashboard Customer | <img src="docs/screenshot/customer-dashboard.png" width="720" alt="Dashboard Customer"> |
| Katalog Homestay | <img src="docs/screenshot/katalog-homestay.png" width="720" alt="Katalog Homestay"> |
| Booking Homestay | <img src="docs/screenshot/booking-homestay.png" width="720" alt="Booking Homestay"> |
| Katalog Souvenir | <img src="docs/screenshot/katalog-souvenir.png" width="720" alt="Katalog Souvenir"> |
| Detail Souvenir | <img src="docs/screenshot/detail-souvenir.png" width="720" alt="Detail Souvenir"> |
| Keranjang | <img src="docs/screenshot/keranjang.png" width="720" alt="Keranjang"> |
| Checkout | <img src="docs/screenshot/checkout-souvenir.png" width="720" alt="Checkout"> |
| Pembayaran | <img src="docs/screenshot/pembayaran.png" width="720" alt="Pembayaran"> |
| Webhook Midtrans | <img src="docs/screenshot/webhook-midtrans.png" width="720" alt="Webhook"> |
| Riwayat Pesanan | <img src="docs/screenshot/riwayat-pesanan.png" width="720" alt="Riwayat"> |
| Dashboard Admin | <img src="docs/screenshot/admin-dashboard.png" width="720" alt="Admin Dashboard"> |
| Admin Homestay | <img src="docs/screenshot/admin-homestay.png" width="720" alt="Admin Homestay"> |
| Admin Kategori | <img src="docs/screenshot/admin-kategori-homestay.png" width="720" alt="Admin Kategori"> |
| Admin Souvenir | <img src="docs/screenshot/admin-souvenir.png" width="720" alt="Admin Souvenir"> |
| Admin Pembayaran | <img src="docs/screenshot/admin-pembayaran.png" width="720" alt="Admin Pembayaran"> |
| Admin Detail Pembayaran | <img src="docs/screenshot/admin-detail-pembayaran.png" width="720" alt="Admin Detail Pembayaran"> |
| Admin Reservasi | <img src="docs/screenshot/admin-reservasi.png" width="720" alt="Admin Reservasi"> |
| Admin Laporan | <img src="docs/screenshot/admin-laporan.png" width="720" alt="Admin Laporan"> |

---

## Struktur Project

```
pentathree-app/
├── app/
│   ├── Http/Controllers/    # Admin, Pelanggan, Auth, Invoice, Webhook, dll
│   ├── Http/Middleware/      # RoleMiddleware, EnsureEmailIsVerified
│   ├── Models/               # User, Homestay, Souvenir, Pemesanan, dll
│   └── Services/             # PaymentSettlement, Midtrans, ImageUpload
├── bootstrap/
├── config/
├── database/
│   ├── migrations/
│   └── seeders/
├── docs/
│   ├── screenshot/           # Screenshot aplikasi
│   ├── dependency.md
│   ├── features.md
│   ├── github_actions.md
│   ├── instalation.md
│   └── refactoring.md
├── public/
├── resources/views/          # Blade templates
├── routes/
│   └── web.php               # Semua route aplikasi
├── tests/                    # Feature tests (Pest)
├── .env.example
├── README.md
├── composer.json
└── package.json
```

---

## Dokumentasi

| Dokumen | Deskripsi |
| --- | --- |
| [docs/features.md](docs/features.md) | Dokumentasi fitur per role |
| [docs/instalation.md](docs/instalation.md) | Panduan instalasi lengkap + Mailtrap |
| [docs/dependency.md](docs/dependency.md) | Analisis dependency + external service |
| [docs/refactoring.md](docs/refactoring.md) | Catatan refactoring dan progress teknis |
| [docs/github_actions.md](docs/github_actions.md) | Dokumentasi CI/CD pipeline |

---

## Troubleshooting

| Masalah | Solusi |
| --- | --- |
| Table not found | `php artisan migrate` |
| Gambar tidak muncul | `php artisan storage:link` |
| Midtrans 401 | `php artisan config:clear` — cek server key |
| Email tidak masuk | Cek `.env` Mailtrap, `php artisan optimize:clear` |
| Halaman tidak berubah | `php artisan view:cache && php artisan config:clear` |
| Test gagal | `php artisan test` untuk lihat detail error |

---

## Progress Sprint

| Sprint | Status |
| --- | --- |
| Sprint 0–8 (MVP Core) | Selesai |
| Sprint 9 (Polish & Optional) | Aktif |

---

## Tim Pengembang — PentaThree

| Nama | Peran |
| --- | --- |
| Zackri Kurnia Amri | Project Manager |
| Yelsa Pagansa Putri | Lead Programmer |
| Zikri Ilham Pratama | Lead Programmer |
| Muhammad Aufi Syahyudi | System Analyst |
| Taufiqurrahman | Quality Assurance |

---

## Status Akademik

Project ini dikembangkan untuk **Project Based Learning (PBL)** — **Konstruksi dan Evolusi Perangkat Lunak**, **D4 Teknologi Rekayasa Perangkat Lunak**, **Politeknik Negeri Padang**.

## Lisensi

Tujuan akademik dan pembelajaran.
