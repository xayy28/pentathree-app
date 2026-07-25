# Analisis Dependency Project PentaThree SIMHOSUV

Terakhir diperbarui: 2026-07-26

Dokumen ini menjelaskan dependency yang dipakai pada project **Sistem Informasi Manajemen Homestay dan Penjualan Souvenir Berbasis Web pada Natasha Homestay & Harau Souvenir** berdasarkan kondisi kode terbaru.

## 1. Ringkasan Status

| Dependency | Package | Status | Penggunaan di project |
| --- | --- | --- | --- |
| Laravel Framework | `laravel/framework:^13.0` | Digunakan | Core backend, routing, controller, model, migration, validation, Blade, email, queue |
| Spatie Laravel Permission | `spatie/laravel-permission:^8.1` | Digunakan | Role admin/user melalui `HasRoles`, tabel permission, fallback `users.role` |
| Laravel DomPDF | `barryvdh/laravel-dompdf:^3.1` | Digunakan | Unduh laporan admin PDF + invoice customer PDF |
| Midtrans PHP SDK | `midtrans/midtrans-php:^2.6` | Digunakan Sandbox | Snap token, webhook notification, cek status transaksi |
| Intervention Image Laravel | `intervention/image-laravel:^4.0` | Digunakan | Resize/optimasi upload gambar via `ImageUploadService` |
| Tailwind CSS | `tailwindcss:^4.2.4` | Digunakan | Styling halaman admin dan pelanggan |
| Vite | `vite:^8.0.0` | Digunakan | Build frontend asset |
| Laravel Vite Plugin | `laravel-vite-plugin:^3.0.0` | Digunakan | Integrasi asset Laravel dan Vite |
| Pest | `pestphp/pest:^4.6` | Digunakan | Feature/unit test |
| Laravel Pint | `laravel/pint:^1.27` | Digunakan | Format kode PHP |
| Mockery | `mockery/mockery:^1.6` | Digunakan | Mock service pada test Midtrans |
| Laravel Breeze | `laravel/breeze:^2.4` | Dev dependency | Scaffolding auth, tetapi auth aktif custom `AuthController` |
| Mailtrap | External Service via SMTP | Digunakan | SMTP sandbox untuk email verifikasi dan password reset |

## 2. Backend Dependencies

### 2.1 Laravel Framework `^13.0`

**Fungsi:** Pondasi utama aplikasi.

**Bagian project yang menggunakan:**
- Routing web di `routes/web.php`
- Controller admin (`Admin\*`) dan pelanggan (`Pelanggan\*`)
- Eloquent model: `User`, `Homestay`, `Souvenir`, `Keranjang`, `KeranjangItem`, `Pemesanan`, `DetailPemesanan`, `Pembayaran`, `Invoice`, `Ulasan`, `Fasilitas`, `KategoriHomestay`
- Migration database
- Blade view engine
- Validation request
- Session, cache, queue, storage
- Email via Mailtrap SMTP (verifikasi email + password reset)
- Queue (tersedia secara infrastruktur, belum digunakan aktif)
- Authentication scaffolding (custom)

**Tipe:** Utama (`require`)

### 2.2 Laravel Breeze `^2.4`

**Fungsi:** Scaffolding authentication.

**Bagian project yang menggunakan:**
- Tidak digunakan secara langsung. Auth aktif memakai custom `AuthController`, `ForgotPasswordController`, `ResetPasswordController`, `EmailVerificationController`.

**Catatan:**
- Breeze tetap terpasang sebagai dev dependency, tetapi project tidak menjalankan `php artisan breeze:install` agar tidak menimpa auth custom.
- Tidak ada file Breeze yang di-override.

**Tipe:** Development (`require-dev`)

### 2.3 Spatie Laravel Permission `^8.1`

**Fungsi:** Role dan permission admin/user.

**Bagian project yang menggunakan:**
- Model `User` memakai trait `Spatie\Permission\Traits\HasRoles`
- Migration `create_permission_tables` (tabel: `roles`, `permissions`, `model_has_roles`, `role_has_permissions`, `model_has_permissions`)
- Seeder `RoleSeeder` dan `DatabaseSeeder` membuat role `admin` dan `user`
- Register user meng-assign role `user`
- Middleware `RoleMiddleware` — fallback ke kolom legacy `users.role` jika Spatie tables belum tersedia

**File terkait:**
- `app/Models/User.php`
- `app/Http/Middleware/RoleMiddleware.php`
- `database/migrations/2026_06_29_212459_create_permission_tables.php`
- `database/seeders/RoleSeeder.php`
- `database/seeders/DatabaseSeeder.php`
- `tests/Feature/RolePermissionTest.php`

**Tipe:** Utama (`require`)

### 2.4 Laravel DomPDF `^3.1`

**Fungsi:** Generate dokumen PDF dari HTML Blade.

**Bagian project yang menggunakan:**
- **Admin Laporan PDF:** `Admin\LaporanController::downloadPdf()` — filter tanggal, ringkasan pendapatan, penjualan souvenir, reservasi homestay
- **Invoice Customer/Admin PDF:** `InvoiceController::buildPdf()` — invoice format A4 portrait
- Template PDF: `resources/views/invoices/pdf.blade.php`, `resources/views/admin/laporan/pdf.blade.php`

**File terkait:**
- `app/Http/Controllers/Admin/LaporanController.php`
- `app/Http/Controllers/InvoiceController.php`
- `resources/views/admin/laporan/pdf.blade.php`
- `resources/views/invoices/pdf.blade.php`
- `tests/Feature/LaporanTest.php`

**Tipe:** Utama (`require`)

### 2.5 Midtrans PHP SDK `^2.6`

**Fungsi:** Payment gateway online via Midtrans Sandbox.

**Bagian project yang menggunakan:**
- Konfigurasi di `config/midtrans.php`
- Endpoint membuat Snap token untuk popup pembayaran
- Webhook notification handler di `MidtransWebhookController`
- Fallback cek status transaksi via `Pelanggan\MidtransPaymentController::status()`
- Settlement otomatis via `PaymentSettlementService` (update stok souvenir, invoice issuance)
- Metode pembayaran dikunci setelah user memilih Midtrans

**Environment variable:**
```
MIDTRANS_SERVER_KEY=
MIDTRANS_CLIENT_KEY=
MIDTRANS_IS_PRODUCTION=false
MIDTRANS_IS_SANITIZED=true
MIDTRANS_IS_3DS=true
```

**Catatan:**
- Sandbox dipakai untuk demo PBL tanpa uang asli
- Jangan commit key asli ke repository
- Production membutuhkan aktivasi merchant dan dokumen bisnis
- Untuk localhost, webhook Midtrans tidak selalu bisa masuk; tersedia fallback cek status

**Tipe:** Utama (`require`)

### 2.6 Intervention Image Laravel `^4.0`

**Fungsi:** Optimasi dan resize gambar upload.

**Bagian project yang menggunakan:**
- Upload foto profil user (`ProfileController`)
- Upload foto homestay (`Admin\HomestayController`)
- Upload foto souvenir (`Admin\SouvenirController`)
- Upload bukti pembayaran (`Pelanggan\PembayaranController`)
- Semua upload melewati `ImageUploadService` — resize, konversi ke WebP

**File terkait:**
- `app/Services/ImageUploadService.php`
- `app/Http/Controllers/ProfileController.php`
- `app/Http/Controllers/Admin/HomestayController.php`
- `app/Http/Controllers/Admin/SouvenirController.php`
- `app/Http/Controllers/Pelanggan/PembayaranController.php`

**Tipe:** Utama (`require`)

### 2.7 Pest `^4.6` + Pest Plugin Laravel `^4.1`

**Fungsi:** Test runner dan assertion library.

**Test aktif (13 file feature test):**
- `AdminReservasiTest`
- `HomestayBookingTest`
- `HomestayTest`
- `KategoriHomestayTest`
- `LaporanTest`
- `MidtransPaymentTest`
- `PembayaranTest`
- `PemesananTest`
- `RolePermissionTest`
- `SouvenirCheckoutTest`
- `SouvenirTest`
- (tambah: `FasilitasTest`, `UlasanTest` jika sudah ada)

**Tipe:** Development (`require-dev`)

### 2.8 Laravel Pint `^1.27`

**Fungsi:** Format kode PHP sesuai standar.

**Command:**
```bash
vendor\bin\pint --dirty
```

**Tipe:** Development (`require-dev`)

### 2.9 Mockery `^1.6`

**Fungsi:** Mocking framework untuk test PHP.

**Bagian project yang menggunakan:**
- Test Midtrans (mock Snap token, payload webhook)

**Tipe:** Development (`require-dev`)

### 2.10 Dependency Pendukung Lainnya

| Package | Tipe | Fungsi |
| --- | --- | --- |
| `laravel/tinker:^3.0` | Utama | REPL interaktif Laravel |
| `fakerphp/faker:^1.23` | Dev | Generator data palsu untuk seeder/test |
| `laravel/pail:^1.2.5` | Dev | Log viewer realtime di terminal |
| `nunomaduro/collision:^8.6` | Dev | Error handler yang lebih informatif |

## 3. Frontend Dependencies

### 3.1 Tailwind CSS `^4.2.4`

**Fungsi:** Utility-first CSS framework.

**Bagian project yang menggunakan:**
- Semua halaman admin: dashboard, CRUD, pembayaran, reservasi, laporan
- Semua halaman pelanggan: dashboard, katalog, booking, keranjang, checkout, pembayaran, riwayat pesanan, profil, homepage
- Halaman publik: welcome, informasi (FAQ, cara pemesanan, kebijakan privasi, syarat ketentuan)
- Auth pages: login, register, forgot-password, reset-password, verify-email

**Plugin:**
- `@tailwindcss/vite:^4.2.4` — integrasi dengan Vite

### 3.2 Vite `^8.0.0`

**Fungsi:** Build tool frontend.

**Command:**
```bash
npm run dev   # development server
npm run build # production build
```

**Plugin:**
- `laravel-vite-plugin:^3.0.0` — integrasi asset Laravel

### 3.3 Concurrently `^9.0.1`

**Fungsi:** Menjalankan multiple command secara paralel.

**Digunakan di:** `composer run dev` — menjalankan `php artisan serve`, `php artisan queue:listen`, dan `npm run dev` secara bersamaan.

## 4. External Services

### 4.1 Mailtrap

**Fungsi:** SMTP sandbox untuk pengujian email.

**Fitur yang menggunakan email:**
- Verifikasi email pengguna baru (wajib sebelum akses booking/pembayaran)
- Password reset / lupa password
- Notifikasi verifikasi email dikirim ulang

**Cara project terhubung:**
- SMTP: `sandbox.smtp.mailtrap.io:2525`
- TLS encryption
- Username dan password dari Mailtrap inbox
- Tidak menggunakan Laravel Queue — email dikirim sinkron

**Environment variable:**
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

**Cara menguji email:**
1. Buka [Mailtrap.io](https://mailtrap.io) dan login
2. Buka Email Testing → pilih inbox
3. Salin SMTP credentials ke `.env`
4. Jalankan aplikasi
5. Register akun baru → email verifikasi akan masuk ke inbox Mailtrap
6. Klik link verifikasi untuk mengaktifkan akun
7. Coba fitur lupa password → email reset akan masuk ke inbox yang sama

**Troubleshooting:**
- Email tidak masuk: cek `.env` sudah benar, jalankan `php artisan optimize:clear`
- Port SMTP salah: pastikan port 2525 (bukan 587 atau 465)
- Credential salah: regenerasi dari dashboard Mailtrap
- `MAIL_FROM_ADDRESS` tidak diisi: beberapa email provider menolak
- Cache config: `php artisan config:clear`

### 4.2 Midtrans Sandbox

(Lihat bagian 2.5)

## 5. Dependency Testing dan Quality Gate

### 5.1 Test Suite

**Test runner:** Pest (via `php artisan test`)

**Feature test aktif:**
- Admin reservation
- Homestay booking + overlap detection
- Homestay CRUD + filter
- Kategori homestay
- Fasilitas CRUD
- Laporan PDF
- Midtrans payment (Snap token, webhook, settlement)
- Pembayaran manual + admin verification + settlement
- Pemesanan relations
- Role permission
- Souvenir checkout
- Souvenir CRUD + filter + detail + cart
- Ulasan (review/rating)

### 5.2 Quality Gate

| Command | Fungsi |
| --- | --- |
| `php artisan test` | Jalankan seluruh test suite |
| `vendor/bin/pint --dirty` | Format kode PHP |
| `npm run build` | Build asset frontend |
| `git diff --check` | Cek whitespace error |

## 6. Dependency yang Tidak Digunakan

| Dependency/Fitur | Status | Catatan |
| --- | --- | --- |
| Laravel Breeze scaffold | Tidak dipakai untuk auth | Auth custom tetap dipakai |
| Queue | Infrastruktur siap | Tidak ada Job class, tidak ada dispatch |
| Scheduler | Tidak dikonfigurasi | Tidak ada task terjadwal |
| Midtrans Production | Belum aktif | Butuh aktivasi merchant |
| Mailtrap Production (sending) | Belum | Masih sandbox untuk testing |

## 7. Kesimpulan

Dependency utama project sudah sesuai dengan implementasi terbaru:
- Laravel 13 sebagai core framework
- Spatie Permission untuk role admin/user
- DomPDF untuk laporan dan invoice PDF
- Midtrans Sandbox untuk payment gateway
- Intervention Image untuk optimasi upload gambar
- Mailtrap SMTP untuk email verifikasi dan password reset
- Pest + Pint + Vite untuk test, format, dan build
- Fasilitas CRUD, Ulasan, Homepage publik sudah berjalan
- Email verification dan password reset aktif via Mailtrap
