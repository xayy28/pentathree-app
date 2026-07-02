# Dokumentasi Refactoring dan Progress Teknis

Terakhir diperbarui: 2026-07-02

Dokumen ini mencatat kondisi arsitektur, refactoring yang sudah dilakukan, dan prioritas refactoring berikutnya pada project PentaThree SIMHOSUV.

## 1. Status Project

Status umum: **MVP hampir selesai, Sprint 8 selesai secara kode, Sprint 9 berikutnya untuk polish dan QA final**.

Sprint selesai:

| Sprint | Nama | Status |
| --- | --- | --- |
| Sprint 0 | Stabilization | Done |
| Sprint 1 | Pemesanan Core | Done |
| Sprint 2 | Souvenir Checkout | Done |
| Sprint 3 | Payment Core | Done |
| Sprint 4 | Invoice | Skipped sementara |
| Sprint 5 | Homestay Booking | Done |
| Sprint 6 | Admin Reservation Management | Done |
| Sprint 6.5 | Stabilization and Demo Readiness | Done |
| Sprint 7 | Reports | Done |
| Sprint 8 | Midtrans Sandbox Integration | Done |
| Sprint 9 | Polish and Optional Scope | Next |

## 2. Struktur Teknis Saat Ini

### 2.1 Model Utama

| Model | Fungsi |
| --- | --- |
| `User` | Akun admin/user, role Spatie, fallback kolom `role` |
| `KategoriHomestay` | Kategori homestay |
| `Homestay` | Data homestay |
| `Souvenir` | Data produk souvenir |
| `Keranjang` | Keranjang user |
| `KeranjangItem` | Item keranjang |
| `Pemesanan` | Induk order untuk souvenir dan homestay |
| `DetailPemesanan` | Detail item souvenir atau detail booking homestay |
| `Pembayaran` | Data pembayaran manual atau Midtrans |

### 2.2 Controller Admin

| Controller | Fungsi |
| --- | --- |
| `Admin\HomestayController` | CRUD homestay |
| `Admin\KategoriHomestayController` | CRUD kategori homestay |
| `Admin\SouvenirController` | CRUD souvenir |
| `Admin\PembayaranController` | Pembayaran souvenir manual/Midtrans |
| `Admin\ReservasiController` | Manajemen reservasi homestay |
| `Admin\LaporanController` | Laporan dan unduh PDF |

### 2.3 Controller Pelanggan

| Controller | Fungsi |
| --- | --- |
| `Pelanggan\HomestayController` | Katalog homestay dan filter |
| `Pelanggan\HomestayBookingController` | Booking homestay |
| `Pelanggan\SouvenirController` | Katalog/detail souvenir |
| `Pelanggan\KeranjangController` | Keranjang dan checkout souvenir |
| `Pelanggan\PemesananController` | Riwayat dan detail pesanan |
| `Pelanggan\PembayaranController` | Upload bukti pembayaran manual |
| `Pelanggan\MidtransPaymentController` | Snap token dan cek status Midtrans |
| `Pelanggan\ReservasiController` | Redirect legacy reservasi ke flow aktif |

### 2.4 Service

| Service | Fungsi |
| --- | --- |
| `ImageUploadService` | Resize dan simpan gambar upload |
| `PaymentSettlementService` | Menyelesaikan pembayaran sukses dan update stok sekali saja |
| `MidtransPaymentService` | Konfigurasi SDK, Snap token, status transaksi, signature |
| `MidtransPaymentStatusService` | Mapping status Midtrans ke status pembayaran internal |

## 3. Refactoring yang Sudah Selesai

### 3.1 Pemesanan Backbone

Sebelum:

- Souvenir dan homestay berpotensi punya flow order terpisah.

Sesudah:

- Semua order masuk ke `pemesanans`.
- Detail order masuk ke `detail_pemesanans`.
- `jenis_pemesanan` membedakan `souvenir` dan `homestay`.

Manfaat:

- Riwayat pesanan user lebih konsisten.
- Payment bisa dipakai untuk souvenir dan homestay.
- Report bisa membaca data dari struktur yang sama.

Status: **selesai**.

### 3.2 Checkout Souvenir

Sebelum:

- Checkout belum membentuk pemesanan yang lengkap.

Sesudah:

- Keranjang dikonversi ke pemesanan.
- Detail item disalin ke `detail_pemesanans`.
- Stok divalidasi sebelum checkout.
- Keranjang dikosongkan setelah checkout.
- User langsung masuk halaman pembayaran.

Status: **selesai**.

### 3.3 Payment Core

Sebelum:

- Belum ada record pembayaran yang stabil.

Sesudah:

- Ada tabel `pembayarans`.
- User bisa upload bukti pembayaran manual.
- Admin bisa verifikasi/tolak.
- Verifikasi sukses update status pemesanan.
- Stok souvenir berkurang sekali saja.
- Rejected payment tidak mengurangi stok.

Status: **selesai**.

### 3.4 Homestay Booking

Sebelum:

- Reservasi belum terhubung ke backbone pemesanan.

Sesudah:

- Booking homestay memakai `pemesanans` dan `detail_pemesanans`.
- Validasi check-in, check-out, dan jumlah tamu.
- Hitung jumlah malam dan subtotal.
- Setelah booking, user langsung masuk halaman pembayaran.

Status: **selesai**.

### 3.5 Admin Reservation Management

Sebelum:

- Admin belum punya kontrol reservasi homestay berbasis pemesanan.

Sesudah:

- Admin bisa melihat list/detail reservasi.
- Admin bisa update status reservasi.
- Filter status tersedia.
- Homestay yang masih punya reservasi aktif tidak bisa dihapus sembarangan.

Status: **selesai**.

### 3.6 Report dan PDF

Sebelum:

- Laporan belum menghitung data transaksi valid.

Sesudah:

- Admin bisa melihat summary pendapatan terverifikasi.
- Ada laporan penjualan souvenir.
- Ada laporan reservasi homestay.
- Ada filter tanggal.
- Ada unduh PDF memakai DomPDF.

Status: **selesai**.

### 3.7 Midtrans Sandbox

Sebelum:

- Payment hanya manual.
- Belum ada gateway online.

Sesudah:

- Midtrans Sandbox aktif.
- User bisa membuka Snap popup.
- Sistem menyimpan order id, snap token, status transaksi, payment type, VA/payment code.
- Webhook notification tersedia.
- Fallback cek status tersedia untuk localhost.
- Settlement sukses memakai `PaymentSettlementService`.
- Metode pembayaran terkunci setelah memilih Midtrans.
- Manual transfer tidak bisa menimpa Midtrans.
- Setelah pembayaran sukses/pending, user diarahkan ke riwayat pesanan.

Status: **selesai secara kode, perlu UAT browser untuk dua flow: souvenir dan homestay**.

### 3.8 Image Upload

Sebelum:

- Upload gambar raw berpotensi besar dan tidak seragam.

Sesudah:

- Upload gambar melewati `ImageUploadService`.
- Gambar di-resize.
- Upload baru disimpan sebagai WebP.
- Dipakai pada profil, homestay, souvenir, dan bukti pembayaran.

Status: **selesai**.

### 3.9 Role Access

Sebelum:

- Role hanya mengandalkan kolom `users.role`.

Sesudah:

- Spatie Laravel Permission dipakai.
- Kolom `users.role` tetap jadi fallback agar data lama aman.
- Test role sudah ada.

Status: **selesai**.

## 4. Test Coverage Saat Ini

Feature test aktif:

- Admin reservation.
- Homestay booking.
- Homestay CRUD/filter.
- Kategori homestay.
- Laporan dan PDF.
- Midtrans payment.
- Pembayaran manual/admin verification.
- Pemesanan relation.
- Role permission.
- Souvenir checkout.
- Souvenir CRUD/filter/detail/cart.

Status terakhir:

```bash
php artisan test
# 86 passed
```

Quality gate:

```bash
vendor\bin\pint --dirty
npm run build
git diff --check
```

Status terakhir:

```text
Pint passed
Build passed
Diff check clean
```

## 5. Prioritas Refactoring Berikutnya

### Prioritas 1 - Sprint 9 QA Final

Wajib sebelum tambah fitur:

- Test manual flow souvenir dari katalog sampai pembayaran.
- Test manual flow homestay dari booking sampai pembayaran.
- Cek riwayat pesanan setelah pembayaran.
- Cek status pembayaran pending/sukses/gagal.
- Cek admin pembayaran.
- Cek admin reservasi.
- Cek laporan PDF.

Status: **belum**.

### Prioritas 2 - Rapikan Risiko Security

Yang perlu dicek:

- Pastikan `.env.example` tidak menyimpan key Midtrans asli.
- Pastikan `.env` tetap gitignored.
- Pastikan upload file hanya menerima format aman.
- Pastikan admin route tetap dibatasi role admin.

Status: **belum final**.

### Prioritas 3 - Invoice Customer

Sprint 4 invoice sebelumnya di-skip.

Jika dosen meminta invoice:

- Buat tabel `invoices`.
- Generate invoice setelah pembayaran valid.
- Buat halaman invoice customer.
- Buat tampilan invoice admin.
- Tambahkan export/print PDF jika dibutuhkan.
- Tambahkan test invoice.

Status: **belum**.

### Prioritas 4 - Optional Scope

Opsional setelah MVP stabil:

- Public homepage.
- Fasilitas homestay.
- Ulasan/rating.
- Email notification.
- Perbaikan UI mikro.
- Search/filter tambahan.

Status: **belum**.

## 6. Commit Message yang Relevan

Commit Sprint 8 payment flow:

```bash
fix: improve midtrans payment flow and order history redirect
```

Commit jika nanti update dokumentasi:

```bash
docs: sync project documentation with sprint 8 progress
```

Commit jika nanti security env example:

```bash
chore: replace midtrans example keys with placeholders
```

## 7. Kesimpulan

Refactoring utama sudah membuat project lebih konsisten:

- Satu backbone order untuk souvenir dan homestay.
- Payment manual dan Midtrans memakai data pembayaran yang sama.
- Settlement pembayaran aman dari pengurangan stok ganda.
- Report membaca pembayaran terverifikasi.
- Test coverage sudah cukup kuat untuk MVP.

Langkah paling aman berikutnya adalah Sprint 9: **QA final dan polish**, bukan menambah fitur besar dulu.
