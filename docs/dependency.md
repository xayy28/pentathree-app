# Analisis Dependency Project PentaThree SIMHOSUV

Terakhir diperbarui: 2026-07-02

Dokumen ini menjelaskan dependency yang dipakai pada project **Sistem Informasi Manajemen Homestay dan Penjualan Souvenir Berbasis Web pada Natasha Homestay & Harau Souvenir** berdasarkan kondisi kode terbaru.

## 1. Ringkasan Status

| Dependency | Package | Status | Penggunaan di project |
| --- | --- | --- | --- |
| Laravel Framework | `laravel/framework:^13.0` | Digunakan | Core backend, routing, controller, model, migration, validation, Blade |
| Laravel Breeze | `laravel/breeze:^2.4` | Terpasang dev dependency | Pendukung scaffolding auth, tetapi auth aktif tetap custom memakai `AuthController` |
| Spatie Laravel Permission | `spatie/laravel-permission:^8.1` | Digunakan | Role admin/user melalui `HasRoles`, tabel permission, dan fallback `users.role` |
| Laravel DomPDF | `barryvdh/laravel-dompdf:^3.1` | Digunakan | Unduh laporan admin dalam format PDF |
| Midtrans PHP SDK | `midtrans/midtrans-php:^2.6` | Digunakan Sandbox | Snap token, webhook notification, cek status transaksi |
| Intervention Image Laravel | `intervention/image-laravel:^4.0` | Digunakan | Resize/optimasi upload gambar melalui `ImageUploadService` |
| Tailwind CSS | `tailwindcss:^4.2.4` | Digunakan | Styling halaman admin dan user |
| Vite | `vite:^8.0.0` | Digunakan | Build frontend asset |
| Laravel Vite Plugin | `laravel-vite-plugin:^3.0.0` | Digunakan | Integrasi asset Laravel dan Vite |
| Pest | `pestphp/pest:^4.6` | Digunakan | Feature/unit test |
| Laravel Pint | `laravel/pint:^1.27` | Digunakan | Format kode PHP |
| Mockery | `mockery/mockery:^1.6` | Digunakan | Mock service pada test Midtrans |

## 2. Dependency PHP Utama

### 2.1 Laravel Framework

Laravel menjadi pondasi utama aplikasi. Fitur Laravel yang aktif:

- Routing web di `routes/web.php`.
- Controller admin dan pelanggan.
- Eloquent model untuk user, homestay, souvenir, keranjang, pemesanan, detail pemesanan, dan pembayaran.
- Migration database.
- Blade view.
- Validation request.
- Session, cache, queue, dan storage.

Status: **digunakan penuh**.

### 2.2 Laravel Breeze

Breeze sudah ada di `require-dev`, tetapi project tidak memakai ulang scaffold Breeze secara penuh. Alur autentikasi aktif tetap custom:

- `app/Http/Controllers/AuthController.php`
- `resources/views/auth/login.blade.php`
- `resources/views/auth/register.blade.php`
- `routes/web.php`

Alasan:

- Project memakai field lokal seperti `nama`, `no_hp`, `alamat`, dan `role`.
- Redirect login berbeda antara admin dan user.
- UI sudah disesuaikan dengan kebutuhan project.

Status: **terpasang sebagai dependency development, tidak dijalankan ulang agar tidak menimpa auth custom**.

### 2.3 Spatie Laravel Permission

Spatie digunakan untuk role admin dan user.

Implementasi aktif:

- Model `User` memakai trait `Spatie\Permission\Traits\HasRoles`.
- Migration permission tersedia melalui `create_permission_tables`.
- Seeder membuat role `admin` dan `user`.
- Register user meng-assign role user.
- Middleware role tetap punya fallback ke kolom legacy `users.role`.

File terkait:

- `app/Models/User.php`
- `app/Http/Middleware/RoleMiddleware.php`
- `database/migrations/2026_06_29_212459_create_permission_tables.php`
- `database/seeders/DatabaseSeeder.php`
- `tests/Feature/RolePermissionTest.php`

Status: **digunakan**.

### 2.4 Laravel DomPDF

DomPDF dipakai untuk fitur laporan PDF admin.

Implementasi aktif:

- Admin membuka halaman laporan.
- Admin bisa filter tanggal laporan.
- Admin bisa unduh laporan dalam format PDF.
- PDF dibuat dari Blade khusus laporan.

File terkait:

- `app/Http/Controllers/Admin/LaporanController.php`
- `resources/views/admin/laporan/index.blade.php`
- `resources/views/admin/laporan/pdf.blade.php`
- `tests/Feature/LaporanTest.php`

Catatan penting:

- DomPDF saat ini dipakai untuk **laporan**, bukan invoice customer.
- Invoice customer masih status rencana/opsional.

Status: **digunakan**.

### 2.5 Midtrans PHP SDK

Midtrans dipakai dalam mode Sandbox untuk pembayaran online.

Implementasi aktif:

- Konfigurasi Midtrans di `config/midtrans.php`.
- Env key: `MIDTRANS_SERVER_KEY`, `MIDTRANS_CLIENT_KEY`, `MIDTRANS_IS_PRODUCTION`, `MIDTRANS_IS_SANITIZED`, `MIDTRANS_IS_3DS`.
- Endpoint membuat Snap token.
- Snap popup di halaman pembayaran pelanggan.
- Webhook notification dari Midtrans.
- Fallback cek status transaksi untuk localhost.
- Pembayaran sukses memakai logic settlement yang sama dengan verifikasi payment core.
- Metode pembayaran dikunci setelah user memilih Midtrans.
- Manual transfer tidak bisa menimpa pembayaran Midtrans.
- Setelah pembayaran selesai, user diarahkan ke riwayat pesanan.

File terkait:

- `config/midtrans.php`
- `app/Services/MidtransPaymentService.php`
- `app/Services/MidtransPaymentStatusService.php`
- `app/Services/PaymentSettlementService.php`
- `app/Http/Controllers/Pelanggan/MidtransPaymentController.php`
- `app/Http/Controllers/MidtransWebhookController.php`
- `resources/views/pelanggan/pembayaran/create.blade.php`
- `tests/Feature/MidtransPaymentTest.php`

Catatan Sandbox:

- Sandbox bisa dipakai untuk demo PBL tanpa uang asli.
- Key Sandbox jangan di-hardcode di kode.
- Production membutuhkan aktivasi merchant dan dokumen owner/bisnis.
- Untuk localhost, webhook Midtrans tidak selalu bisa masuk. Gunakan tombol/status check fallback.

Status: **digunakan Sandbox**.

### 2.6 Intervention Image Laravel

Intervention Image dipakai untuk optimasi gambar upload.

Implementasi aktif:

- Upload foto profil.
- Upload foto homestay.
- Upload foto souvenir.
- Upload bukti pembayaran.
- Resize dengan batas ukuran.
- Output disimpan sebagai WebP untuk upload baru.

File terkait:

- `app/Services/ImageUploadService.php`
- `app/Http/Controllers/ProfileController.php`
- `app/Http/Controllers/Admin/HomestayController.php`
- `app/Http/Controllers/Admin/SouvenirController.php`
- `app/Http/Controllers/Pelanggan/PembayaranController.php`

Status: **digunakan**.

## 3. Dependency Frontend

### 3.1 Tailwind CSS

Tailwind digunakan langsung pada Blade untuk membangun UI admin dan user.

Area yang memakai Tailwind:

- Dashboard.
- Katalog homestay.
- Katalog souvenir.
- Detail souvenir.
- Keranjang dan checkout.
- Pembayaran.
- Riwayat pesanan.
- Admin CRUD.
- Admin pembayaran.
- Admin reservasi.
- Admin laporan.

Status: **digunakan**.

### 3.2 Vite dan Laravel Vite Plugin

Vite dipakai untuk build asset frontend.

Command utama:

```bash
npm run dev
npm run build
```

Status: **digunakan**.

## 4. Dependency Testing dan Quality Gate

### 4.1 Pest

Pest dipakai sebagai test runner.

Test aktif:

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

Status terakhir:

```bash
php artisan test
# 86 passed
```

### 4.2 Laravel Pint

Pint dipakai untuk format kode PHP.

Command:

```bash
vendor\bin\pint --dirty
```

Status terakhir: **passed**.

### 4.3 Vite Build

Command:

```bash
npm run build
```

Status terakhir: **passed**.

## 5. Dependency yang Belum atau Tidak Dipakai

| Dependency/Fitur | Status | Catatan |
| --- | --- | --- |
| Font Awesome | Belum terpasang | UI saat ini tidak bergantung ke Font Awesome |
| Invoice customer | Belum dibuat penuh | Sprint 4 sempat di-skip; DomPDF sekarang hanya untuk laporan |
| Midtrans Production | Belum | Butuh aktivasi merchant dan dokumen owner/bisnis |
| Email notification | Belum | Opsional untuk sprint polish |
| Ulasan/rating | Belum | Opsional setelah order/reservasi selesai |
| Fasilitas homestay | Belum | Opsional jika dosen meminta detail fasilitas |

## 6. Kesimpulan

Dependency utama project sudah sesuai dengan progress terbaru:

- Auth custom tetap dipakai, Breeze hanya dependency development.
- Role sudah memakai Spatie dengan fallback kolom `users.role`.
- Laporan PDF sudah memakai DomPDF.
- Upload gambar sudah memakai Intervention Image.
- Payment gateway sudah memakai Midtrans Sandbox.
- Test dan build sudah memakai Pest, Pint, dan Vite.

Project saat ini sudah melewati Sprint 8. Sprint berikutnya adalah Sprint 9 untuk polish, QA final, dan fitur opsional.
