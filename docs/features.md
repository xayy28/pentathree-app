# Feature Documentation

Dokumen ini menjelaskan fitur-fitur utama pada project **PentaThree SIMHOSUV - Sistem Informasi Manajemen Homestay dan Penjualan Souvenir Berbasis Web pada Natasha Homestay & Harau Souvenir**.

Terakhir diperbarui: 2026-07-26

---

## Fitur Guest (Belum Login)

### 1. Public Homepage

**Tujuan:** Halaman utama publik yang menampilkan informasi homestay, souvenir, dan ulasan tanpa login.

**Aktor:** Guest, Customer, Admin

**Alur:**
Guest membuka URL root. Sistem menampilkan hero section, daftar homestay tersedia (max 3), daftar souvenir terlaris (max 4), statistik total (homestay, souvenir, user, rating), dan ulasan terbaru rating >= 4. Guest dapat login/register dari halaman ini.

**Route:**
- `GET /` — `name: home`
- Controller: Closure di `routes/web.php`
- View: `resources/views/welcome.blade.php`

---

### 2. Login

**Tujuan:** Admin dan pelanggan masuk ke sistem.

**Aktor:** Admin, Customer

**Alur:**
User membuka halaman login, memasukkan email dan password. `AuthController::login()` memvalidasi, membuat session, redirect berdasarkan role (admin → `/admin/dashboard`, user → `/dashboard`).

**Route:**
- `GET /login` — `name: login`
- `POST /login`
- Controller: `AuthController`
- View: `resources/views/auth/login.blade.php`

**Screenshot:** `screenshot/login.png`

---

### 3. Register

**Tujuan:** Customer membuat akun baru.

**Aktor:** Customer

**Alur:**
Customer mengisi nama, email, no HP, alamat, password, konfirmasi password. `AuthController::register()` validasi, simpan ke `users`, assign role `user` via Spatie, kirim email verifikasi via Mailtrap.

**Route:**
- `GET /register` — `name: register`
- `POST /register`
- Controller: `AuthController`
- View: `resources/views/auth/register.blade.php`

**Screenshot:** `screenshot/register.png`

---

### 4. Lupa Password

**Tujuan:** Customer mereset password melalui email.

**Aktor:** Customer, Admin

**Alur:**
User memasukkan email terdaftar. `ForgotPasswordController::sendResetLinkEmail()` mengirim link reset via Mailtrap. User klik link, masuk halaman reset password, memasukkan password baru. `ResetPasswordController::reset()` memproses perubahan.

**Route:**
- `GET /forgot-password` — `name: password.request`
- `POST /forgot-password` — `name: password.email`
- `GET /reset-password/{token}` — `name: password.reset`
- `POST /reset-password` — `name: password.update`
- Controller: `ForgotPasswordController`, `ResetPasswordController`
- View: `resources/views/auth/forgot-password.blade.php`, `resources/views/auth/reset-password.blade.php`

<!-- Screenshot: forgot-password.png -->

---

## Fitur Customer (Setelah Login)

### 5. Dashboard Customer

**Tujuan:** Halaman awal customer dengan ringkasan informasi.

**Aktor:** Customer

**Alur:**
Customer login → diarahkan ke `/dashboard`. Sistem menampilkan homestay tersedia (4), souvenir terlaris (4), total homestay/souvenir, pesanan aktif, pesanan terakhir, total ulasan, dan rating rata-rata.

**Route:**
- `GET /dashboard` — `name: dashboard`
- View: `resources/views/pelanggan/dashboard.blade.php`

**Screenshot:** `screenshot/dashboard-customer.png`

---

### 6. Email Verification

**Tujuan:** Memverifikasi email customer sebelum mengakses booking/pembayaran.

**Aktor:** Customer, Sistem

**Alur:**
Setelah register, sistem kirim email verifikasi via Mailtrap. Customer klik link signed URL. `EmailVerificationController::verify()` memvalidasi ID, hash, signature. Jika valid, `markEmailAsVerified()`. Akses ke rute booking/pembayaran dibatasi middleware `verified.email` sampai email terverifikasi. Customer bisa minta kirim ulang via `resend()`.

**Route:**
- `GET /email/verify` — `name: verification.notice`
- `POST /email/verification-notification` — `name: verification.send` (throttle: 6,1)
- `GET /email/verify/{id}/{hash}` — `name: verification.verify` (signed)
- Controller: `EmailVerificationController`
- View: `resources/views/auth/verify-email.blade.php`

<!-- Screenshot: email-verification.png -->

---

### 7. Manajemen Profil

**Tujuan:** User melihat/memperbarui data akun.

**Aktor:** Admin, Customer

**Alur:**
User buka `/profile`, lihat data. Bisa ubah nama, no HP, alamat, foto profil (via `ImageUploadService` — resize, WebP). Bisa ganti password via halaman terpisah.

**Route:**
- `GET /profile` — `name: profile.show`
- `GET /profile/edit` — `name: profile.edit`
- `PUT /profile` — `name: profile.update`
- `GET /profile/password/edit` — `name: profile.password.edit`
- `PUT /profile/password` — `name: profile.password.update`
- Controller: `ProfileController`

**Screenshot:** `screenshot/profile.png`

---

### 8. Informasi Halaman

**Tujuan:** Menyediakan halaman informasi untuk customer.

**Aktor:** Customer, Admin

**Halaman:**
- FAQ — `GET /informasi/faq`
- Cara Pemesanan — `GET /informasi/cara-pemesanan`
- Kebijakan Privasi — `GET /informasi/kebijakan-privasi`
- Syarat & Ketentuan — `GET /informasi/syarat-ketentuan`
- Controller: `InformasiController`

<!-- Screenshot: informasi-faq.png -->

---

### 9. Katalog Homestay

**Tujuan:** Customer melihat daftar homestay tersedia.

**Aktor:** Customer

**Alur:**
Customer buka `/homestay`. Sistem tampilkan daftar homestay dengan nama, kategori, harga/malam, kapasitas, status, foto, rating. Filter berdasarkan kategori, status, kapasitas.

**Route:**
- `GET /homestay` — `name: user.homestay`
- `GET /homestay/{homestay_id}` — `name: user.homestay.show`
- Controller: `Pelanggan\HomestayController`
- View: `resources/views/pelanggan/homestay/index.blade.php`, `pelanggan/homestay/show.blade.php`

**Screenshot:** `screenshot/katalog-homestay.png`

---

### 10. Booking Homestay

**Tujuan:** Customer reservasi homestay dengan tanggal menginap.

**Aktor:** Customer (wajib email terverifikasi)

**Alur:**
Customer pilih homestay → buka halaman booking → isi check-in, check-out, jumlah tamu, catatan. Sistem validasi: check-out > check-in, tamu <= kapasitas, tidak overlap booking aktif. Hitung jumlah malam + subtotal. `HomestayBookingController::store()` menggunakan `DB::transaction()` + `lockForUpdate()` untuk mencegah double booking. Setelah sukses, redirect ke halaman pembayaran.

**Teknis:**
- Date overlap: `check_in < check_out AND check_out > check_in` — hanya booking aktif (tidak dibatalkan/kedaluwarsa) yang memblokir
- Menampilkan kalender tanggal terbooking via `bookedDates()`
- Locking homestay row pakai `lockForUpdate()`

**Route:**
- `GET /homestay/{homestay_id}/booking` — `name: user.homestay.booking.create`
- `POST /homestay/{homestay_id}/booking` — `name: user.homestay.booking.store`
- Controller: `Pelanggan\HomestayBookingController`

**Screenshot:** `screenshot/booking-homestay.png`

---

### 11. Katalog dan Detail Souvenir

**Tujuan:** Customer melihat produk souvenir.

**Aktor:** Customer

**Alur:**
Customer buka `/souvenir`. Lihat daftar souvenir dengan foto, harga, stok, status, jumlah terjual. Filter status, lihat terlaris. Buka detail souvenir, lihat info lengkap, tambah ke keranjang atau pesan sekarang.

**Route:**
- `GET /souvenir` — `name: user.souvenir`
- `GET /souvenir/{souvenir_id}` — `name: user.souvenir.show`
- Controller: `Pelanggan\SouvenirController`

**Screenshot:** `screenshot/katalog-souvenir.png`, `screenshot/detail-souvenir.png`

---

### 12. Keranjang Souvenir

**Tujuan:** Menyimpan sementara souvenir sebelum checkout.

**Aktor:** Customer (wajib email terverifikasi)

**Alur:**
Customer tambah souvenir dari halaman detail → sistem buat/update `KeranjangItem`. Customer buka `/cart` → lihat daftar item, ubah jumlah, hapus item, lanjut checkout. Validasi stok: jumlah tidak boleh melebihi stok.

**Route:**
- `GET /cart` — `name: cart.index`
- `POST /cart/add` — `name: cart.add`
- `PUT /cart/update` — `name: cart.update`
- `DELETE /cart/{id}` — `name: cart.destroy`
- Controller: `Pelanggan\KeranjangController`

**Screenshot:** `screenshot/keranjang.png`

---

### 13. Checkout Souvenir

**Tujuan:** Mengubah keranjang menjadi pemesanan.

**Aktor:** Customer (wajib email terverifikasi)

**Alur:**
Customer buka `/cart/checkout`. Sistem tampilkan ringkasan item, subtotal, biaya layanan, pilihan pengiriman, total. Proses checkout: validasi stok, buat `Pemesanan` (jenis souvenir), salin item keranjang ke `DetailPemesanan`, hitung total, kosongkan keranjang, redirect ke halaman pembayaran. Menggunakan `DB::transaction()`.

**Route:**
- `GET /cart/checkout` — `name: checkout.index`
- `POST /cart/checkout` — `name: checkout.store`
- Controller: `Pelanggan\KeranjangController`

**Screenshot:** `screenshot/checkout-souvenir.png`

---

### 14. Pembayaran Customer

**Tujuan:** Customer membayar pemesanan souvenir atau homestay.

**Aktor:** Customer, Sistem (wajib email terverifikasi)

**Alur:**
Setelah booking/checkout, customer diarahkan ke halaman pembayaran. Customer pilih:
- **Midtrans Online:** Sistem buat Snap token → popup Midtrans → webhook / fallback cek status → settlement otomatis
- **Transfer Manual (3 metode):** `transfer_bank`, `qris_manual`, `tunai` → upload bukti pembayaran (jpeg/png/jpg/webp, max 2MB) → status `menunggu_verifikasi` → admin verifikasi

**Penguncian metode:**
- Jika pilih Midtrans, metode dikunci (manual transfer tidak bisa menimpa)
- Jika sudah upload manual, Midtrans ditolak dengan pesan

**Settlement otomatis:** `PaymentSettlementService::verify()` pakai `DB::transaction()` + `lockForUpdate()` → kurangi stok souvenir → update status → buat invoice

**Route:**
- `GET /pesanan/{pemesanan_id}/pembayaran` — `name: user.pembayaran.create`
- `POST /pesanan/{pemesanan_id}/pembayaran` — `name: user.pembayaran.store`
- `POST /pesanan/{pemesanan_id}/midtrans-token` — `name: user.pembayaran.midtrans.token`
- `POST /pesanan/{pemesanan_id}/midtrans-status` — `name: user.pembayaran.midtrans.status`
- Controller: `Pelanggan\PembayaranController`, `Pelanggan\MidtransPaymentController`
- Service: `MidtransPaymentService`, `MidtransPaymentStatusService`, `PaymentSettlementService`

**Screenshot:** `screenshot/pembayaran.png`

---

### 15. Riwayat Pesanan Customer

**Tujuan:** Customer melihat daftar pemesanan.

**Aktor:** Customer

**Alur:**
Customer buka `/pesanan`. Sistem tampilkan daftar pemesanan milik customer: kode pemesanan, jenis (souvenir/homestay), total harga, status pemesanan, status pembayaran, tanggal. Customer bisa buka detail, lihat item souvenir atau detail booking.

**Route:**
- `GET /pesanan` — `name: user.pesanan.index`
- `GET /pesanan/{pemesanan_id}` — `name: user.pesanan.show`
- Controller: `Pelanggan\PemesananController`

**Screenshot:** `screenshot/riwayat-pesanan.png`, `screenshot/detail-pesanan.png`

---

### 16. Invoice Customer

**Tujuan:** Bukti transaksi setelah pembayaran valid.

**Aktor:** Customer, Admin, Sistem

**Alur:**
Setelah payment settlement, `PaymentSettlementService::issueInvoice()` buat invoice (format nomor: `INV-YYYYMMDD-NNNN`). Customer lihat invoice dari detail pesanan. Bisa unduh PDF via DomPDF.

**Route:**
- `GET /pesanan/{pemesanan_id}/invoice` — `name: user.invoices.show`
- `GET /pesanan/{pemesanan_id}/invoice/pdf` — `name: user.invoices.pdf`
- Controller: `InvoiceController`
- Model: `Invoice`
- Service: `PaymentSettlementService`

<!-- Screenshot: invoice.png, invoice-pdf.png -->

---

### 17. Ulasan (Review/Rating)

**Tujuan:** Customer memberi rating dan komentar setelah pembayaran terverifikasi.

**Aktor:** Customer

**Alur:**
Customer buka detail pesanan, beri rating (1-5) dan komentar (opsional) per item. `UlasanController::store()` validasi: hanya untuk detail pemesanan milik customer yang pembayarannya sudah `STATUS_TERVERIFIKASI`. Sistem `updateOrCreate` untuk mencegah duplikasi.

**Route:**
- `POST /pesanan/{pemesanan_id}/detail/{detail_pemesanan_id}/ulasan` — `name: user.ulasan.store`
- Controller: `Pelanggan\UlasanController`
- Model: `Ulasan`

<!-- Screenshot: ulasan.png -->

---

## Fitur Admin

### 18. Dashboard Admin

**Tujuan:** Ringkasan data operasional sistem.

**Aktor:** Admin

**Alur:**
Admin login → `/admin/dashboard`. `Admin\DashboardController` menghitung: total homestay (baru bulan ini), souvenir (tersedia, habis, stok menipis), reservasi aktif, pesanan souvenir aktif, pendapatan (hari ini, bulan ini, bulan lalu, total), pembayaran (menunggu, ditolak, terverifikasi), user (total, baru, admin, pelanggan), ulasan (total, bulan ini, distribusi rating), tren pendapatan 6 bulan, popular homestay, best seller souvenir, cek-in mendatang.

**Route:**
- `GET /admin/dashboard` — `name: admin.dashboard`
- Controller: `Admin\DashboardController`
- View: `resources/views/admin/dashboard.blade.php`

**Screenshot:** `screenshot/admin-dashboard.png`

---

### 19. Manajemen Kategori Homestay

**Tujuan:** Admin mengelola kategori homestay.

**Aktor:** Admin

**Alur:**
Admin lihat daftar kategori, tambah (nama, icon), edit, hapus. Jika kategori masih digunakan homestay, hapus ditolak.

**Route:**
- `GET /admin/kategori-homestay` — `name: admin.kategori-homestay`
- `GET /admin/kategori-homestay/create` — `name: admin.kategori-homestay.create`
- `POST /admin/kategori-homestay` — `name: admin.kategori-homestay.store`
- `GET /admin/kategori-homestay/{kategori_id}/edit` — `name: admin.kategori-homestay.edit`
- `PUT /admin/kategori-homestay/{kategori_id}` — `name: admin.kategori-homestay.update`
- `DELETE /admin/kategori-homestay/{kategori_id}` — `name: admin.kategori-homestay.destroy`
- Controller: `Admin\KategoriHomestayController`

**Screenshot:** `screenshot/admin-kategori-homestay.png`

---

### 20. Manajemen Fasilitas Homestay

**Tujuan:** Admin mengelola daftar fasilitas yang bisa dipasang ke homestay.

**Aktor:** Admin

**Alur:**
Admin lihat daftar fasilitas, tambah (nama, ikon), edit, hapus. Jika fasilitas masih digunakan homestay, hapus ditolak.

**Route:**
- `GET /admin/fasilitas` — `name: admin.fasilitas`
- `GET /admin/fasilitas/create` — `name: admin.fasilitas.create`
- `POST /admin/fasilitas` — `name: admin.fasilitas.store`
- `GET /admin/fasilitas/{fasilitas_id}/edit` — `name: admin.fasilitas.edit`
- `PUT /admin/fasilitas/{fasilitas_id}` — `name: admin.fasilitas.update`
- `DELETE /admin/fasilitas/{fasilitas_id}` — `name: admin.fasilitas.destroy`
- Controller: `Admin\FasilitasController`
- Model: `Fasilitas`

<!-- Screenshot: admin-fasilitas.png -->

---

### 21. Manajemen Homestay

**Tujuan:** Admin mengelola data penginapan.

**Aktor:** Admin

**Alur:**
Admin lihat daftar homestay (filter kategori & status), tambah (nama, kategori, harga, kapasitas, deskripsi, fasilitas, foto), edit, hapus. Jika homestay masih punya reservasi aktif, hapus ditolak. Upload foto via `ImageUploadService`.

**Route:**
- `GET /admin/homestay` — `name: admin.homestay`
- `GET /admin/homestay/create` — `name: admin.homestay.create`
- `POST /admin/homestay` — `name: admin.homestay.store`
- `GET /admin/homestay/{homestay_id}/edit` — `name: admin.homestay.edit`
- `PUT /admin/homestay/{homestay_id}` — `name: admin.homestay.update`
- `DELETE /admin/homestay/{homestay_id}` — `name: admin.homestay.destroy`
- Controller: `Admin\HomestayController`

**Screenshot:** `screenshot/admin-homestay.png`

---

### 22. Manajemen Souvenir

**Tujuan:** Admin mengelola produk souvenir.

**Aktor:** Admin

**Alur:**
Admin lihat daftar souvenir, tambah (nama, harga, stok, status, deskripsi, foto), edit, hapus. Sistem simpan `updated_by` (admin terakhir). Upload foto via `ImageUploadService`.

**Route:**
- `GET /admin/souvenir` — `name: admin.souvenir`
- `GET /admin/souvenir/create` — `name: admin.souvenir.create`
- `POST /admin/souvenir` — `name: admin.souvenir.store`
- `GET /admin/souvenir/{souvenir_id}/edit` — `name: admin.souvenir.edit`
- `PUT /admin/souvenir/{souvenir_id}` — `name: admin.souvenir.update`
- `DELETE /admin/souvenir/{souvenir_id}` — `name: admin.souvenir.destroy`
- Controller: `Admin\SouvenirController`

**Screenshot:** `screenshot/admin-souvenir.png`

---

### 23. Admin Manajemen User

**Tujuan:** Admin melihat daftar user.

**Aktor:** Admin

**Alur:**
Admin buka `/admin/user`. Lihat daftar user dengan filter role. Lihat statistik total admin, total pelanggan, total terverifikasi.

**Route:**
- `GET /admin/user` — `name: admin.user`
- Controller: `Admin\UserController`

<!-- Screenshot: admin-user.png -->

---

### 24. Admin Pembayaran Souvenir

**Tujuan:** Admin memantau/memverifikasi pembayaran souvenir.

**Aktor:** Admin

**Alur:**
Admin lihat daftar pembayaran (filter status). Buka detail — lihat data customer, kode pesanan, metode, bukti bayar / data Midtrans. Untuk manual: verify (update status, stok, invoice) atau reject.

**Route:**
- `GET /admin/pembayaran` — `name: admin.pembayaran`
- `GET /admin/pembayaran/{pembayaran_id}` — `name: admin.pembayaran.show`
- `POST /admin/pembayaran/{pembayaran_id}/verify` — `name: admin.pembayaran.verify`
- `POST /admin/pembayaran/{pembayaran_id}/reject` — `name: admin.pembayaran.reject`
- `POST /admin/pembayaran/{pembayaran_id}/status` — `name: admin.pembayaran.status`
- `POST /admin/pembayaran/{pembayaran_id}/complete` — `name: admin.pembayaran.complete`
- Controller: `Admin\PembayaranController`
- Service: `PaymentSettlementService`

**Screenshot:** `screenshot/admin-pembayaran.png`, `screenshot/admin-detail-pembayaran.png`

---

### 25. Admin Reservasi Homestay

**Tujuan:** Admin mengelola reservasi homestay.

**Aktor:** Admin

**Alur:**
Admin lihat daftar reservasi (filter status). Buka detail — lihat data customer, check-in, check-out, malam, total, status pembayaran. Ubah status: diproses, dikonfirmasi, dibatalkan, selesai. Verify/reject payment reservasi.

**Route:**
- `GET /admin/reservasi` — `name: admin.reservasi`
- `GET /admin/reservasi/{pemesanan_id}` — `name: admin.reservasi.show`
- `POST /admin/reservasi/{pemesanan_id}/status` — `name: admin.reservasi.status`
- `POST /admin/reservasi/{pemesanan_id}/verify-payment` — `name: admin.reservasi.verify-payment`
- `POST /admin/reservasi/{pemesanan_id}/reject-payment` — `name: admin.reservasi.reject-payment`
- Controller: `Admin\ReservasiController`

**Screenshot:** `screenshot/admin-reservasi.png`

---

### 26. Admin Invoice

**Tujuan:** Admin melihat dan mengunduh invoice pembayaran terverifikasi.

**Aktor:** Admin

**Alur:**
Admin buka invoice dari detail pembayaran atau reservasi. Lihat tampilan HTML atau unduh PDF via DomPDF.

**Route:**
- `GET /admin/invoices/{invoice_id}` — `name: admin.invoices.show`
- `GET /admin/invoices/{invoice_id}/pdf` — `name: admin.invoices.pdf`
- Controller: `InvoiceController`

<!-- Screenshot: admin-invoice.png -->

---

### 27. Notifikasi Transaksi

**Tujuan:** Admin melihat notifikasi transaksi baru.

**Aktor:** Admin

**Alur:**
Admin mengakses notifikasi transaksi via `/admin/notifikasi/transaksi/{pemesanan_id}`. Sistem menandai pesanan sudah dilihat admin (`tandaiDilihatAdmin()`), lalu redirect ke halaman detail sesuai jenis (reservasi homestay / pembayaran souvenir).

**Route:**
- `GET /admin/notifikasi/transaksi/{pemesanan_id}` — `name: admin.notifikasi.transaksi`
- Controller: `Admin\NotifikasiTransaksiController`

---

### 28. Laporan dan Unduh PDF

**Tujuan:** Admin melihat ringkasan pendapatan dan laporan.

**Aktor:** Admin

**Alur:**
Admin buka `/admin/laporan`. Lihat ringkasan: pendapatan terverifikasi, pembayaran menunggu, jumlah reservasi, penjualan souvenir, status reservasi, pembayaran terverifikasi terbaru. Filter tanggal. Unduh PDF via DomPDF.

**Route:**
- `GET /admin/laporan` — `name: admin.laporan`
- `GET /admin/laporan/pdf` — `name: admin.laporan.pdf`
- Controller: `Admin\LaporanController`
- View PDF: `resources/views/admin/laporan/pdf.blade.php`

**Screenshot:** `screenshot/admin-laporan.png`

---

## Fitur Sistem (Otomatis)

### 29. Webhook Midtrans

**Tujuan:** Menerima notifikasi status pembayaran dari Midtrans.

**Aktor:** Midtrans, Sistem

**Alur:**
Midtrans kirim POST ke `/midtrans/notification` (tanpa CSRF). `MidtransWebhookController::handle()` verifikasi signature (`hash_equals`), cari `Pembayaran` via `midtrans_order_id`. `MidtransPaymentStatusService::apply()` mapping status: `settlement`/`capture` → verifikasi via `PaymentSettlementService`, `pending` → mark pending, `capture + challenge` → mark review, `deny`/`cancel`/`expire`/`failure` → mark failed.

**Route:**
- `POST /midtrans/notification` — tanpa CSRF — `name: midtrans.notification`
- Controller: `MidtransWebhookController`
- Services: `MidtransPaymentService`, `MidtransPaymentStatusService`, `PaymentSettlementService`

**Screenshot:** `screenshot/webhook-midtrans.png`

---

### 30. Payment Settlement

**Tujuan:** Memproses efek pembayaran sukses tepat satu kali.

**Aktor:** Sistem

**Alur:**
`PaymentSettlementService::verify()` pakai `DB::transaction()` + `lockForUpdate()`:
1. Idempotency guard — jika sudah terverifikasi, skip
2. Untuk souvenir: validasi stok, `decrement('stok')`, `increment('jumlah_terjual')`
3. Update `pembayarans.status_pembayaran = terverifikasi`
4. Update `pemesanans.status_pemesanan` (souvenir → terverifikasi, homestay → dikonfirmasi)
5. `issueInvoice()` — buat invoice dengan nomor auto-generated `INV-YYYYMMDD-NNNN`

---

### 31. Role dan Hak Akses

**Tujuan:** Membatasi akses halaman berdasarkan role.

**Aktor:** Admin, Customer, Sistem

**Alur:**
Sistem periksa via `RoleMiddleware`: coba Spatie `$user->hasRole()`, fallback ke `$user->role`. Route admin pakai `middleware('role:admin')`, route customer pakai `middleware('role:user')`. Rute booking/pembayaran juga butuh `middleware('verified.email')`.

**Komponen:**
- Middleware: `RoleMiddleware`, `EnsureEmailIsVerified`
- Model: `User` (trait `HasRoles`)
- Package: `spatie/laravel-permission:^8.1`
- Seeder: `RoleSeeder`, `DatabaseSeeder`

**Screenshot:** `screenshot/hak-akses.png`

---

### 32. Optimasi Upload Gambar

**Tujuan:** File gambar tidak terlalu besar.

**Aktor:** Admin, Customer, Sistem

**Alur:**
Semua upload via `ImageUploadService` — resize sesuai batas, output WebP. Berlaku untuk: foto profil, foto homestay, foto souvenir, bukti pembayaran. Gambar lama dihapus saat diganti.

**Komponen:**
- Service: `ImageUploadService`
- Package: `intervention/image-laravel:^4.0`

**Screenshot:** `screenshot/upload-gambar.png`

---

### 33. Email Notification (Mailtrap)

**Tujuan:** Mengirim email verifikasi dan password reset.

**Aktor:** Sistem, Mailtrap

**Fitur email aktif:**
- Email verifikasi akun baru (custom `VerifyEmailNotification`)
- Email reset password (bawaan Laravel `Password::broker()`)

**Implementasi:**
- Mailtrap SMTP Sandbox (`sandbox.smtp.mailtrap.io:2525`)
- Email dikirim sinkron (tidak pakai queue)
- Belum ada email untuk: konfirmasi pembayaran, konfirmasi booking, invoice

**Konfigurasi:**
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

<!-- Screenshot: mailtrap-inbox.png -->

---

### 34. Testing dan Quality Gate

**Tujuan:** Memastikan fitur utama tetap berjalan.

**Aktor:** Developer

**Command:**
```bash
php artisan test          # Pest test suite
vendor/bin/pint --dirty   # Format PHP
npm run build             # Build frontend
git diff --check           # Cek whitespace
```

**Test coverage:** Admin reservation, Homestay booking, CRUD, Kategori, Fasilitas, Laporan PDF, Midtrans payment, Pembayaran manual, Pemesanan, Role permission, Souvenir checkout, Souvenir CRUD.

**Screenshot:** `screenshot/testing.png`

---

## Ringkasan Status Fitur

| Fitur | Status |
| --- | --- |
| Public homepage | Selesai |
| Login dan register | Selesai |
| Lupa/reset password via email | Selesai |
| Email verifikasi (Mailtrap) | Selesai |
| Role admin/customer (Spatie + fallback) | Selesai |
| Halaman informasi (FAQ, cara pemesanan, dll) | Selesai |
| Dashboard admin dan customer | Selesai |
| Profil user + upload foto | Selesai |
| CRUD kategori homestay | Selesai |
| CRUD fasilitas homestay | Selesai |
| CRUD homestay | Selesai |
| CRUD souvenir | Selesai |
| Admin manajemen user | Selesai |
| Notifikasi transaksi admin | Selesai |
| Katalog homestay + filter | Selesai |
| Booking homestay + date blocking | Selesai |
| Katalog dan detail souvenir | Selesai |
| Keranjang souvenir | Selesai |
| Checkout souvenir | Selesai |
| Payment manual (transfer_bank, qris_manual, tunai) | Selesai |
| Midtrans Sandbox (Snap, webhook, fallback) | Selesai |
| Settlement pembayaran (stok, invoice) | Selesai |
| Riwayat pesanan | Selesai |
| Admin pembayaran (verify/reject) | Selesai |
| Admin reservasi (status, verify payment) | Selesai |
| Invoice customer + PDF (DomPDF) | Selesai |
| Invoice admin + PDF | Selesai |
| Laporan admin + PDF | Selesai |
| Ulasan/rating customer | Selesai |
| Email notification (verifikasi, reset password) | Selesai via Mailtrap |
| Optimasi upload gambar (ImageUploadService) | Selesai |
| GitHub Actions CI | Tersedia |
| Laravel Queue | Infrastruktur siap, belum dipakai |
| Laravel Scheduler | Tidak dikonfigurasi |
| Midtrans Production | Belum |
| Email transaksional (pembayaran, booking, invoice) | Belum |
