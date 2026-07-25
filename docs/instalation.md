# Panduan Instalasi Project PentaThree SIMHOSUV

Terakhir diperbarui: 2026-07-26

Dokumen ini menjelaskan cara menjalankan project Laravel PentaThree SIMHOSUV.

## 1. Kebutuhan Sistem

**Minimal:**
- PHP 8.3 atau lebih baru
- Composer
- Node.js 20 atau lebih baru
- NPM
- MySQL/MariaDB
- Git

**Ekstensi PHP yang disarankan:**
- `pdo_mysql`, `pdo_sqlite`
- `mbstring`, `fileinfo`, `openssl`, `curl`, `gd`, `xml`, `ctype`, `json`

## 2. Clone Repository

```bash
git clone https://github.com/xayy28/pentathree-app.git
cd pentathree-app
```

## 3. Install Dependency

```bash
composer install
```

Dependency utama yang terinstall: Laravel 13, Spatie Permission, Midtrans PHP SDK, DomPDF, Intervention Image, Pest, Pint.

```bash
npm install
```

Dependency frontend: Tailwind CSS 4, Vite 8, Laravel Vite Plugin, @tailwindcss/vite, concurrently.

## 4. Setup File Environment

```bash
copy .env.example .env
php artisan key:generate
```

Untuk PowerShell:
```powershell
Copy-Item .env.example .env
php artisan key:generate
```

## 5. Konfigurasi Database

Buat database MySQL:
```sql
CREATE DATABASE pentathree_app;
```

Sesuaikan `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pentathree_app
DB_USERNAME=root
DB_PASSWORD=
```

## 6. Konfigurasi Midtrans Sandbox

Daftar akun di [Midtrans Dashboard](https://dashboard.midtrans.com). Ambil Server Key dan Client Key dari menu Settings → Access Keys (mode Sandbox).

```env
MIDTRANS_SERVER_KEY=Mid-server-xxxxx
MIDTRANS_CLIENT_KEY=Mid-client-xxxxx
MIDTRANS_IS_PRODUCTION=false
MIDTRANS_IS_SANITIZED=true
MIDTRANS_IS_3DS=true
```

Jangan commit key asli ke repository.

## 7. Konfigurasi Mailtrap (Email)

Project menggunakan Mailtrap SMTP Sandbox untuk email verifikasi dan password reset.

### 7.1 Setup Akun Mailtrap

1. Buka [Mailtrap.io](https://mailtrap.io) dan login/daftar.
2. Masuk ke **Email Testing**.
3. Buat inbox baru atau gunakan inbox bawaan.
4. Klik tab **SMTP Settings** → pilih **Laravel 9+** atau **Integration**.
5. Salin credential SMTP.

### 7.2 Konfigurasi di .env

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

Setelah mengubah, jalankan:
```bash
php artisan config:clear
```

### 7.3 Fitur yang Menggunakan Email

- **Verifikasi email** — otomatis terkirim saat register. Customer harus verifikasi agar bisa akses booking/pembayaran.
- **Reset password** — link dikirim saat user lupa password.

### 7.4 Cara Cek Email di Mailtrap

1. Buka [Mailtrap.io](https://mailtrap.io) → Email Testing
2. Klik inbox yang sesuai
3. Email masuk akan muncul di daftar
4. Klik email untuk lihat isi HTML/plaintext
5. Untuk verifikasi, klik link di preview email

### 7.5 Troubleshooting Email

| Masalah | Solusi |
| --- | --- |
| Email tidak masuk | Cek `.env`, jalankan `php artisan optimize:clear` |
| Port salah | Pastikan port 2525, bukan 587/465 |
| Credential salah | Regenerasi dari dashboard Mailtrap |
| `MAIL_FROM_ADDRESS` kosong | Isi dengan alamat email valid |
| Cache config usang | `php artisan config:clear` |
| Queue worker tidak jalan | (Project tidak pakai queue untuk email) |

## 8. Migrasi dan Seeder

```bash
php artisan migrate --seed
php artisan storage:link
```

Atau terpisah:
```bash
php artisan migrate
php artisan db:seed
php artisan storage:link
```

Tabel utama: `users`, `roles`/`permissions` (Spatie), `kategori_homestays`, `homestays`, `fasilitas`, `homestay_fasilitas`, `souvenirs`, `keranjangs`, `keranjang_items`, `pemesanans`, `detail_pemesanans`, `pembayarans`, `invoices`, `ulasans`, `jobs`, `cache`.

## 9. Menjalankan Project

**Backend:**
```bash
php artisan serve
```

**Frontend (Vite):**
```bash
npm run dev
```

**Gabungan (server + queue listen + vite):**
```bash
composer run dev
```

URL lokal: `http://127.0.0.1:8000`

## 10. Build Production Asset

```bash
npm run build
```

Wajib sukses sebelum demo atau deploy.

## 11. Menjalankan Test

```bash
php artisan test
```

Format kode:
```bash
vendor\bin\pint --dirty
```

Cek whitespace:
```bash
git diff --check
```

## 12. Akun Demo

Setelah `php artisan db:seed`:

| Role | Email | Password |
| --- | --- | --- |
| Admin | `admin@aura.com` | `admin123` |
| Customer | `user@aura.com` | `user123` |

## 13. Alur Demo

### Pembelian Souvenir
1. Login sebagai user
2. Buka katalog souvenir
3. Tambah ke keranjang
4. Checkout (wajib email verifikasi)
5. Pilih Midtrans atau manual transfer
6. Bayar → lihat riwayat pesanan
7. Admin verifikasi (jika manual) → invoice terbit

### Reservasi Homestay
1. Login sebagai user
2. Buka katalog homestay
3. Pilih homestay → isi tanggal booking
4. Bayar → admin lihat reservasi
5. Admin update status reservasi

### Admin
1. Login sebagai admin
2. Kelola homestay, fasilitas, kategori, souvenir, user
3. Verifikasi pembayaran
4. Kelola reservasi
5. Lihat laporan + unduh PDF

## 14. Testing Midtrans Sandbox

Kartu uji Sandbox Midtrans:
```
Card Number: 4811 1111 1111 1114
CVV: 123
Expiry: bulan/tahun masa depan
OTP/3DS: 112233
```

Simulator Virtual Account: `https://simulator.sandbox.midtrans.com/`

## 15. Error Umum

### Table Tidak Ada
```bash
php artisan migrate
php artisan migrate:status
```

### Storage Gambar Tidak Tampil
```bash
php artisan storage:link
php artisan view:clear
```

### Midtrans 401
```bash
php artisan config:clear
```
Cek `MIDTRANS_IS_PRODUCTION=false` dan server key.

### Curl SSL Error
Download `cacert.pem`, set `curl.cainfo` dan `openssl.cafile` di `php.ini`, restart server.

### Halaman Lama
```bash
php artisan view:clear
php artisan cache:clear
php artisan config:clear
```

## 16. Progress Sprint

| Sprint | Nama | Status |
| --- | --- | --- |
| Sprint 0 | Stabilization | Done |
| Sprint 1 | Pemesanan Core | Done |
| Sprint 2 | Souvenir Checkout | Done |
| Sprint 3 | Payment Core | Done |
| Sprint 4 | Invoice | Done |
| Sprint 5 | Homestay Booking | Done |
| Sprint 6 | Admin Reservation Management | Done |
| Sprint 6.5 | Stabilization and Demo Readiness | Done |
| Sprint 7 | Reports | Done |
| Sprint 8 | Midtrans Sandbox Integration | Done |
| Sprint 9 | Polish and Optional Scope | In Progress |

## 17. Kesimpulan

Project sudah dapat dijalankan untuk demo akhir PBL:
- Admin CRUD homestay, fasilitas, kategori, souvenir, user
- Customer checkout souvenir + booking homestay
- Payment manual + Midtrans Sandbox
- Admin reservasi + pembayaran + laporan PDF
- Email verifikasi + password reset via Mailtrap
- Invoice customer + PDF
- Ulasan/rating
- Public homepage
- Test dan build berjalan stabil
