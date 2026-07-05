# Panduan Instalasi Project PentaThree SIMHOSUV

Terakhir diperbarui: 2026-07-02

Dokumen ini menjelaskan cara menjalankan project Laravel PentaThree SIMHOSUV berdasarkan kondisi kode terbaru setelah Sprint 8.

## 1. Kebutuhan Sistem

Minimal:

- PHP 8.3 atau lebih baru.
- Composer.
- Node.js 20 atau lebih baru.
- NPM.
- MySQL/MariaDB.
- Git.

Ekstensi PHP yang disarankan:

- `pdo_mysql`
- `pdo_sqlite`
- `mbstring`
- `fileinfo`
- `openssl`
- `curl`
- `gd`
- `xml`
- `ctype`
- `json`

## 2. Clone Repository

```bash
git clone <url-repository>
cd pentathree-app
```

Jika project sudah ada di lokal:

```bash
cd "D:\Project Base Learning\pentathree-app"
```

## 3. Install Dependency Backend

```bash
composer install
```

Dependency penting yang akan terinstall:

- Laravel Framework.
- Spatie Laravel Permission.
- Midtrans PHP SDK.
- Laravel DomPDF.
- Intervention Image Laravel.
- Pest.
- Laravel Pint.

## 4. Install Dependency Frontend

```bash
npm install
```

Dependency frontend:

- Tailwind CSS.
- Vite.
- Laravel Vite Plugin.

## 5. Setup File Environment

Copy file environment:

```bash
copy .env.example .env
```

Generate app key:

```bash
php artisan key:generate
```

Set database lokal:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pentathree_app
DB_USERNAME=root
DB_PASSWORD=
```

Buat database MySQL:

```sql
CREATE DATABASE pentathree_app;
```

## 6. Setup Midtrans Sandbox

Isi key Midtrans di `.env` memakai key Sandbox dari dashboard Midtrans.

Contoh format, jangan pakai key asli di dokumentasi atau git:

```env
MIDTRANS_SERVER_KEY=Mid-server-xxxxx
MIDTRANS_CLIENT_KEY=Mid-client-xxxxx
MIDTRANS_IS_PRODUCTION=false
MIDTRANS_IS_SANITIZED=true
MIDTRANS_IS_3DS=true
```

Catatan:

- Sandbox dipakai untuk demo dan testing.
- Production belum dipakai.
- Production membutuhkan aktivasi merchant dan dokumen owner/bisnis.
- Jangan commit key asli ke repository.

Setelah mengubah `.env`, jalankan:

```bash
php artisan config:clear
```

## 7. Migrasi dan Seeder

Jalankan migration:

```bash
php artisan migrate
```

Jika ingin data demo:

```bash
php artisan db:seed
```

Atau langsung:

```bash
php artisan migrate --seed
```

Tabel utama yang dibuat:

- `users`
- `roles`, `permissions`, dan tabel pivot Spatie.
- `kategori_homestays`
- `homestays`
- `souvenirs`
- `keranjangs`
- `keranjang_items`
- `pemesanans`
- `detail_pemesanans`
- `pembayarans`
- `cache`
- `jobs`

## 8. Setup Storage

Jalankan:

```bash
php artisan storage:link
```

Storage dipakai untuk:

- Foto profil.
- Foto homestay.
- Foto souvenir.
- Bukti pembayaran.

Upload gambar diproses oleh `ImageUploadService` dan dioptimasi memakai Intervention Image.

## 9. Menjalankan Project

Jalankan Laravel:

```bash
php artisan serve
```

Jalankan Vite:

```bash
npm run dev
```

Atau pakai script gabungan:

```bash
composer run dev
```

URL lokal default:

```text
http://127.0.0.1:8000
```

## 10. Build Production Asset

```bash
npm run build
```

Build ini wajib sukses sebelum demo atau deploy.

## 11. Menjalankan Test

Jalankan semua test:

```bash
php artisan test
```

Status terakhir:

```text
86 passed
```

Jalankan test payment saja:

```bash
php artisan test tests\Feature\PembayaranTest.php tests\Feature\MidtransPaymentTest.php
```

Jalankan format kode:

```bash
vendor\bin\pint --dirty
```

Cek whitespace:

```bash
git diff --check
```

## 12. Alur Demo User

### 12.1 Pembelian Souvenir

1. Login sebagai user.
2. Buka katalog souvenir.
3. Tambah souvenir ke keranjang.
4. Checkout keranjang.
5. Sistem membuat pemesanan dan langsung membuka halaman pembayaran.
6. Pilih Midtrans atau transfer manual.
7. Jika memilih Midtrans, metode pembayaran dikunci ke Midtrans.
8. Setelah pembayaran sukses/pending, user diarahkan ke riwayat pesanan.

### 12.2 Reservasi Homestay

1. Login sebagai user.
2. Buka katalog homestay.
3. Pilih homestay dan isi tanggal booking.
4. Sistem membuat pemesanan homestay dan langsung membuka halaman pembayaran.
5. Pilih Midtrans atau transfer manual.
6. Jika memilih Midtrans, metode pembayaran dikunci ke Midtrans.
7. Setelah pembayaran selesai, user diarahkan ke riwayat pesanan.

### 12.3 Admin

1. Login sebagai admin.
2. Kelola kategori homestay.
3. Kelola homestay.
4. Kelola souvenir.
5. Cek pembayaran souvenir.
6. Cek reservasi homestay.
7. Cek laporan.
8. Unduh laporan PDF.

## 13. Testing Midtrans Sandbox

Flow test:

1. Buat pesanan souvenir atau booking homestay.
2. Masuk halaman pembayaran.
3. Klik Midtrans Online.
4. Snap popup muncul.
5. Pilih metode pembayaran Sandbox.
6. Selesaikan pembayaran.
7. Sistem sinkron status.
8. User diarahkan ke riwayat pesanan.

Kartu Sandbox umum:

```text
Card Number: 4811 1111 1111 1114
CVV: 123
Expiry: bulan/tahun masa depan
OTP/3DS: 112233
```

Untuk Virtual Account, gunakan simulator Midtrans Sandbox:

```text
https://simulator.sandbox.midtrans.com/
```

## 14. Error Umum

### 14.1 Table Tidak Ada

Contoh:

```text
Base table or view not found
```

Solusi:

```bash
php artisan migrate
```

Jika migration sudah pernah gagal, cek status:

```bash
php artisan migrate:status
```

### 14.2 Storage Gambar Tidak Tampil

Solusi:

```bash
php artisan storage:link
php artisan view:clear
```

### 14.3 Midtrans 401 Unauthorized

Penyebab paling mungkin:

- Server key salah.
- Client key salah.
- Tertukar antara server key dan client key.
- Mode production/sandbox tidak sesuai.

Solusi:

```bash
php artisan config:clear
```

Lalu cek `.env`:

```env
MIDTRANS_IS_PRODUCTION=false
```

### 14.4 Curl SSL Certificate Error

Contoh error:

```text
CURL Error: SSL certificate OpenSSL verify result: unable to get local issuer certificate
```

Solusi aman untuk Windows/XAMPP:

1. Download `cacert.pem` dari sumber resmi curl.
2. Simpan misalnya di `C:\xampp\php\extras\ssl\cacert.pem`.
3. Edit `php.ini`.
4. Isi:

```ini
curl.cainfo="C:\xampp\php\extras\ssl\cacert.pem"
openssl.cafile="C:\xampp\php\extras\ssl\cacert.pem"
```

5. Restart terminal/server.
6. Jalankan:

```bash
php artisan config:clear
```

### 14.5 Halaman Lama Masih Muncul

Solusi:

```bash
php artisan view:clear
php artisan cache:clear
php artisan config:clear
```

## 15. Progress Sprint Saat Ini

Sudah selesai:

- Sprint 0: Stabilization.
- Sprint 1: Pemesanan Core.
- Sprint 2: Souvenir Checkout.
- Sprint 3: Payment Core.
- Sprint 5: Homestay Booking.
- Sprint 6: Admin Reservation Management.
- Sprint 6.5: Stabilization and Demo Readiness.
- Sprint 7: Reports.
- Sprint 8: Midtrans Sandbox Integration.

Di-skip sementara:

- Sprint 4: Invoice.

Berikutnya:

- Sprint 9: Polish and Optional Scope.

## 16. Kesimpulan

Project sudah bisa dijalankan untuk demo MVP:

- Admin CRUD homestay/souvenir.
- Customer checkout souvenir.
- Customer booking homestay.
- Payment manual dan Midtrans Sandbox.
- Admin reservasi.
- Admin laporan PDF.
- Test dan build sudah berjalan.
