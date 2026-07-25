# Dokumentasi Refactoring dan Progress Teknis

Terakhir diperbarui: 2026-07-26

Dokumen ini mencatat kondisi arsitektur, refactoring yang sudah dilakukan, dan prioritas refactoring berikutnya pada project PentaThree SIMHOSUV.

## 1. Status Project

**Status umum: MVP selesai, Sprint 9 polish aktif.**

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

## 2. Struktur Teknis Saat Ini

### Model Utama

| Model | Fungsi |
| --- | --- |
| `User` | Akun admin/user, role Spatie, fallback kolom `role` |
| `KategoriHomestay` | Kategori homestay |
| `Homestay` | Data homestay |
| `Fasilitas` | Fasilitas homestay |
| `Souvenir` | Data produk souvenir |
| `Keranjang` | Keranjang user |
| `KeranjangItem` | Item keranjang |
| `Pemesanan` | Induk order untuk souvenir dan homestay |
| `DetailPemesanan` | Detail item souvenir atau detail booking homestay |
| `Pembayaran` | Data pembayaran manual atau Midtrans |
| `Invoice` | Invoice otomatis setelah pembayaran valid |
| `Ulasan` | Review/rating customer |

### Controller Admin

| Controller | Fungsi |
| --- | --- |
| `Admin\DashboardController` | Dashboard admin dengan statistik komprehensif |
| `Admin\HomestayController` | CRUD homestay |
| `Admin\KategoriHomestayController` | CRUD kategori homestay |
| `Admin\FasilitasController` | CRUD fasilitas homestay |
| `Admin\SouvenirController` | CRUD souvenir |
| `Admin\UserController` | Manajemen user |
| `Admin\PembayaranController` | Pembayaran souvenir manual/Midtrans |
| `Admin\ReservasiController` | Manajemen reservasi homestay |
| `Admin\LaporanController` | Laporan dan unduh PDF |
| `Admin\NotifikasiTransaksiController` | Notifikasi transaksi baru untuk admin |

### Controller Pelanggan

| Controller | Fungsi |
| --- | --- |
| `Pelanggan\HomestayController` | Katalog homestay dan filter |
| `Pelanggan\HomestayBookingController` | Booking homestay dengan date blocking |
| `Pelanggan\SouvenirController` | Katalog/detail souvenir |
| `Pelanggan\KeranjangController` | Keranjang dan checkout souvenir |
| `Pelanggan\PemesananController` | Riwayat dan detail pesanan |
| `Pelanggan\PembayaranController` | Upload bukti pembayaran manual |
| `Pelanggan\MidtransPaymentController` | Snap token dan cek status Midtrans |
| `Pelanggan\UlasanController` | Review/rating customer |
| `Pelanggan\ReservasiController` | Redirect legacy reservasi ke flow aktif |

### Controller Lainnya

| Controller | Fungsi |
| --- | --- |
| `AuthController` | Login, register, logout |
| `ForgotPasswordController` | Lupa password (kirim link via Mailtrap) |
| `ResetPasswordController` | Reset password |
| `EmailVerificationController` | Verifikasi email (notice, verify, resend) |
| `ProfileController` | Manajemen profil dan password |
| `InvoiceController` | Invoice HTML dan PDF |
| `MidtransWebhookController` | Webhook Midtrans |
| `InformasiController` | Halaman FAQ, cara pemesanan, kebijakan, syarat |

### Service

| Service | Fungsi |
| --- | --- |
| `ImageUploadService` | Resize, WebP, simpan gambar upload |
| `PaymentSettlementService` | Verifikasi pembayaran + kurangi stok + buat invoice (idempotent) |
| `MidtransPaymentService` | Konfigurasi SDK, Snap token, status transaksi, signature |
| `MidtransPaymentStatusService` | Mapping status Midtrans ke status internal |

## 3. Refactoring yang Sudah Selesai

### 3.1 Pemesanan Backbone

**Sebelum:** Souvenir dan homestay punya flow order terpisah.

**Sesudah:** Semua order masuk `pemesanans`. Detail order masuk `detail_pemesanans`. `jenis_pemesanan` membedakan `souvenir` dan `homestay`.

**Manfaat:** Riwayat konsisten, payment reusable, report dari struktur sama.

### 3.2 Checkout Souvenir

**Sebelum:** Checkout belum bentuk pemesanan lengkap.

**Sesudah:** Keranjang → pemesanan → detail_pemesanan. Validasi stok. Kosongkan keranjang. Redirect ke pembayaran.

### 3.3 Payment Core

**Sebelum:** Belum ada record pembayaran stabil.

**Sesudah:** Tabel `pembayarans`. User upload bukti + Midtrans. Admin verify/reject. Settlement idempotent (stok berkurang sekali). Rejected tidak kurangi stok.

### 3.4 Homestay Booking

**Sebelum:** Reservasi belum terhubung ke backbone pemesanan.

**Sesudah:** Booking pakai `pemesanans` + `detail_pemesanans`. Validasi tanggal, kapasitas, overlap. Hitung malam + subtotal. Redirect ke pembayaran. `DB::transaction()` + `lockForUpdate()` cegah double booking.

### 3.5 Admin Reservation Management

**Sebelum:** Admin belum punya kontrol reservasi.

**Sesudah:** Admin lihat list/detail, update status, filter, verify/reject payment. Homestay dengan reservasi aktif tidak bisa dihapus.

### 3.6 Report dan PDF

**Sebelum:** Laporan belum hitung transaksi valid.

**Sesudah:** Summary pendapatan, penjualan souvenir, reservasi, filter tanggal, unduh PDF DomPDF.

### 3.7 Invoice

**Sebelum:** Invoice sempat di-skip.

**Sesudah:** Tabel `invoices`. Auto-generate setelah payment settlement. Nomor format `INV-YYYYMMDD-NNNN`. Customer/admin lihat HTML + PDF (DomPDF). Test anti-duplikasi.

### 3.8 Midtrans Sandbox

**Sebelum:** Payment hanya manual.

**Sesudah:** Snap popup, order id, snap token, webhook, fallback cek status. Settlement via `PaymentSettlementService`. Metode pembayaran terkunci setelah pilih Midtrans. Manual tidak bisa timpa Midtrans, dan sebaliknya.

### 3.9 Image Upload

**Sebelum:** Upload raw, besar, tidak seragam.

**Sesudah:** Via `ImageUploadService` — resize, WebP. Berlaku untuk profil, homestay, souvenir, bukti bayar.

### 3.10 Role Access

**Sebelum:** Hanya kolom `users.role`.

**Sesudah:** Spatie `^8.1` + `HasRoles`. Kolom `users.role` jadi fallback. Test role ada.

### 3.11 Ulasan (Review/Rating)

**Sebelum:** Belum ada fitur review.

**Sesudah:** Model `Ulasan`. Customer beri rating + komentar per item pesanan setelah pembayaran terverifikasi. `updateOrCreate` cegah duplikasi. Homepage + dashboard tampilkan rating.

### 3.12 Fasilitas Homestay

**Sebelum:** Belum ada fitur fasilitas.

**Sesudah:** Model `Fasilitas`. CRUD admin. Relasi many-to-many dengan homestay. Hapus ditolak jika masih dipakai.

### 3.13 Public Homepage

**Sebelum:** Root route redirect ke login/dashboard.

**Sesudah:** Halaman `welcome` dengan hero, daftar homestay, souvenir terlaris, statistik, ulasan terbaru.

### 3.14 Email Verification + Password Reset

**Sebelum:** Belum ada verifikasi email.

**Sesudah:** Kirim email via Mailtrap SMTP saat register. Signed URL verification. Middleware `verified.email` untuk akses booking/pembayaran. Resend notification. Password reset via `Password::broker()`.

### 3.15 Invoice PDF menggunakan DomPDF

**Sebelum:** Invoice hanya cetak browser.

**Sesudah:** `InvoiceController::buildPdf()` pakai `Barryvdh\DomPDF\Facade\Pdf`. Download PDF A4 portrait untuk customer dan admin.

## 4. Test Coverage Saat Ini

Feature test aktif:
- Admin reservation
- Homestay booking (date overlap + lock)
- Homestay CRUD/filter
- Kategori homestay
- Fasilitas CRUD
- Laporan PDF
- Midtrans payment (Snap, webhook, settlement)
- Pembayaran manual + admin verification
- Pemesanan relation
- Role permission
- Souvenir checkout
- Souvenir CRUD/filter/detail/cart
- Ulasan (review)

## 5. Prioritas Refactoring Berikutnya

### Prioritas 1 — Email Transaksional
Buat Mailable/Notification untuk:
- Konfirmasi pembayaran sukses
- Konfirmasi booking homestay
- Invoice

### Prioritas 2 — Queue
Pindahkan email + proses berat ke queue (infrastruktur sudah siap).

### Prioritas 3 — Search/Filter Lanjutan
Search homestay dan souvenir, filter harga, filter tanggal.

### Prioritas 4 — Midtrans Production
Aktivasi merchant, ganti key production, uji end-to-end.

## 6. Kesimpulan

Refactoring utama sudah membuat project konsisten:
- Satu backbone order untuk souvenir dan homestay
- Payment manual dan Midtrans sharing data pembayaran
- Settlement aman dari pengurangan stok ganda (idempotent)
- Report membaca pembayaran terverifikasi
- Invoice otomatis, bisa PDF
- Ulasan dan fasilitas sudah jalan
- Email verifikasi + password reset via Mailtrap
- Public homepage dengan info lengkap
- Test coverage cukup kuat untuk final PBL
