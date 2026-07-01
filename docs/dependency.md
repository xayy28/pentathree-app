# ANALISIS DEPENDENCY / PACKAGE LARAVEL

## Sistem Informasi Manajemen Homestay dan Penjualan Souvenir Berbasis Web pada Natasha Homestay & Harau Souvenir

## 1. Pendahuluan

Dokumen ini berisi analisis dependency/package Laravel yang digunakan dan direncanakan dalam pengembangan project **Sistem Informasi Manajemen Homestay dan Penjualan Souvenir Berbasis Web pada Natasha Homestay & Harau Souvenir**.

Dependency digunakan untuk membantu proses pengembangan sistem agar lebih cepat, terstruktur, aman, dan sesuai dengan kebutuhan fitur. Pada project ini, dependency mendukung beberapa kebutuhan utama seperti autentikasi pengguna, pembagian role, pembuatan invoice PDF, pembayaran digital, pengelolaan gambar, tampilan antarmuka, dan icon website.

---

## 2. Ringkasan Dependency

|  No | Package / Dependency      | Fungsi                                                   | Alasan Digunakan                                                           | Versi / Status      | Risiko                                       |
| --: | ------------------------- | -------------------------------------------------------- | -------------------------------------------------------------------------- | ------------------- | -------------------------------------------- |
|   1 | Laravel Breeze            | Autentikasi login, register, logout, dan dashboard dasar | Mempercepat pembuatan sistem autentikasi untuk admin dan customer          | Digunakan            | Scaffolding tidak dijalankan ulang agar tidak menimpa auth custom |
|   2 | Spatie Laravel Permission | Mengelola role dan permission user                       | Membedakan akses antara admin dan customer                                 | Digunakan            | Role harus dikonfigurasi dan di-seed dengan benar |
|   3 | Laravel DomPDF            | Generate PDF dari data Laravel                           | Dibutuhkan untuk mengunduh laporan admin dalam format PDF                  | Digunakan           | Generate PDF bisa berat jika data besar      |
|   4 | Midtrans Payment Gateway  | Pembayaran digital QRIS dan Virtual Account              | Memudahkan pembayaran online untuk booking homestay dan pembelian souvenir | Rencana             | Membutuhkan API key dan pengujian sandbox    |
|   5 | Intervention Image        | Resize dan optimasi gambar upload                        | Mengurangi ukuran file foto profil, homestay, souvenir, dan bukti pembayaran | Digunakan            | Perlu menjaga kualitas gambar agar tetap jelas |
|   6 | Font Awesome              | Library icon untuk tampilan website                      | Mempercantik menu, tombol, dashboard, dan sosial media                     | Rencana             | Jika memakai CDN, butuh koneksi internet     |
|   7 | Tailwind CSS              | Framework CSS utility-first                              | Membuat tampilan website lebih cepat, responsive, dan modern               | Digunakan            | Class bisa berantakan jika tidak konsisten   |
|   8 | Laravel Validation        | Validasi input form                                      | Mencegah data kosong, salah format, atau tidak valid                       | Bawaan Laravel      | Rule validasi harus sesuai kebutuhan form    |
|   9 | Laravel File Storage      | Menyimpan file upload                                    | Dibutuhkan untuk upload gambar homestay dan souvenir                       | Bawaan Laravel      | Permission folder storage harus benar        |

---

## 3. Dependency yang Digunakan dan Direncanakan

### 3.1 Laravel Breeze

#### Fungsi

Laravel Breeze adalah package autentikasi sederhana untuk Laravel yang menyediakan fitur login, register, logout, reset password, dan dashboard dasar.

#### Alasan Digunakan

Laravel Breeze digunakan karena project ini membutuhkan sistem login dan register untuk pengguna. Dengan Breeze, proses pembuatan autentikasi menjadi lebih cepat karena struktur dasar login dan register sudah disediakan oleh Laravel.

#### Pengguna

Dependency ini digunakan oleh:

- Customer
- Admin

Customer dapat melakukan registrasi dan login untuk melakukan booking homestay atau membeli souvenir. Admin dapat login untuk mengelola data homestay, souvenir, pemesanan, pembayaran, dan laporan.

#### Penerapan pada Project

Laravel Breeze diterapkan pada halaman:

- Login
- Register
- Logout
- Dashboard customer
- Dashboard admin

Catatan implementasi: package Laravel Breeze sudah terpasang sebagai dependency development. Alur auth project tetap memakai `AuthController`, form request, dan view custom agar field lokal seperti `nama`, `no_hp`, `alamat`, serta redirect role admin/customer tidak tertimpa scaffold bawaan.

#### Cara Install

```bash
composer require laravel/breeze --dev
php artisan breeze:install
npm install
npm run dev
php artisan migrate
```

#### Dampak pada Project

- Sistem login dan register lebih cepat dibuat.
- Struktur autentikasi Laravel menjadi lebih rapi.
- Memudahkan pembagian dashboard berdasarkan role.
- Dapat dikembangkan untuk redirect user sesuai role setelah login.

#### Risiko

- Tampilan bawaan Breeze perlu disesuaikan dengan desain project.
- Perlu tambahan middleware agar admin dan customer tidak mengakses dashboard yang salah.
- Redirect setelah login harus dikonfigurasi sesuai role pengguna.

---

### 3.2 Spatie Laravel Permission

#### Fungsi

Spatie Laravel Permission adalah package Laravel yang digunakan untuk mengelola role dan permission pengguna.

#### Alasan Digunakan

Project ini memiliki lebih dari satu jenis pengguna, terutama admin dan customer. Admin memiliki hak akses untuk mengelola data sistem, sedangkan customer hanya dapat melakukan booking, pembelian, pembayaran, melihat status, dan melihat invoice.

#### Pengguna

Dependency ini digunakan oleh:

- Admin
- Customer
- Sistem manajemen hak akses

#### Penerapan pada Project

Spatie Laravel Permission diterapkan pada:

- Dashboard admin
- Dashboard customer
- CRUD data kamar
- CRUD data souvenir
- Manajemen pemesanan
- Verifikasi pembayaran
- Generate laporan
- Riwayat transaksi customer

Pada kode saat ini, Spatie digunakan melalui trait `HasRoles` di model `User`, tabel `roles`, `permissions`, `model_has_roles`, `model_has_permissions`, dan `role_has_permissions`, serta proses assign role pada registrasi dan seeder. Kolom `users.role` tetap dipertahankan sebagai data legacy agar user lama tidak langsung rusak.

#### Cara Install

```bash
composer require spatie/laravel-permission
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
php artisan migrate
```

#### Perubahan File

File yang kemungkinan berubah setelah menggunakan Spatie Laravel Permission adalah:

```text
composer.json
composer.lock
config/permission.php
database/migrations/xxxx_xx_xx_create_permission_tables.php
app/Models/User.php
database/seeders/RoleSeeder.php
routes/web.php
```

#### Tabel Database yang Ditambahkan

```text
roles
permissions
model_has_roles
model_has_permissions
role_has_permissions
```

#### Contoh Role

```php
Role::firstOrCreate(['name' => 'admin']);
Role::firstOrCreate(['name' => 'user']);
```

#### Contoh Penggunaan pada Model User

```php
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;
}
```

#### Contoh Proteksi Route

```php
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
});

Route::middleware(['auth', 'role:user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
});
```

#### Dampak pada Project

- Hak akses admin dan customer dapat dibedakan.
- Menu sidebar dapat ditampilkan sesuai role.
- Halaman admin tidak bisa diakses oleh customer.
- Sistem menjadi lebih aman dan terstruktur.

#### Risiko

- Role harus dibuat terlebih dahulu sebelum user diberikan role.
- Jika middleware salah, user bisa diarahkan ke halaman yang tidak sesuai.
- Perlu menjalankan seeder role agar tidak terjadi error saat register.

---

### 3.3 Laravel DomPDF

#### Fungsi

Laravel DomPDF adalah package yang digunakan untuk membuat file PDF dari tampilan Blade Laravel.

#### Alasan Digunakan

Project ini membutuhkan fitur unduh laporan admin dalam format PDF. Admin dapat menyimpan laporan pendapatan, penjualan souvenir, status reservasi homestay, dan pembayaran terverifikasi sebagai dokumen cetak.

#### Pengguna

Dependency ini digunakan oleh:

- Admin

#### Penerapan pada Project

DomPDF diterapkan pada fitur:

- Unduh laporan admin dalam bentuk PDF
- Cetak ringkasan pendapatan terverifikasi
- Cetak laporan penjualan souvenir
- Cetak laporan status reservasi homestay
- Cetak riwayat pembayaran terverifikasi terbaru

Pada kode saat ini, DomPDF digunakan melalui controller laporan admin dan template Blade khusus PDF.

#### Cara Install

```bash
composer require barryvdh/laravel-dompdf
```

#### Contoh Penggunaan

```php
use Barryvdh\DomPDF\Facade\Pdf;

public function cetakInvoice($id)
{
    $invoice = Invoice::findOrFail($id);

    $pdf = Pdf::loadView('invoice.pdf', compact('invoice'));

    return $pdf->download('invoice-'.$invoice->id.'.pdf');
}
```

#### Dampak pada Project

- Admin dapat mengunduh laporan dalam bentuk PDF.
- Data laporan lebih mudah dicetak dan disimpan.
- Fitur laporan menjadi lebih lengkap untuk kebutuhan demo dan dokumentasi.

#### Risiko

- Generate PDF dapat memengaruhi performa jika data terlalu banyak.
- Desain Blade untuk PDF harus dibuat sederhana agar hasil cetak rapi.
- Package harus sesuai dengan versi Laravel yang digunakan.

---

### 3.4 Midtrans Payment Gateway

#### Fungsi

Midtrans adalah payment gateway yang digunakan untuk memproses pembayaran digital seperti QRIS, Virtual Account, e-wallet, dan metode pembayaran online lainnya.

#### Alasan Digunakan

Project ini membutuhkan sistem pembayaran online agar customer dapat membayar booking homestay atau pembelian souvenir secara lebih mudah, cepat, dan aman.

#### Pengguna

Dependency ini digunakan oleh:

- Customer saat melakukan pembayaran
- Admin saat memverifikasi status pembayaran
- Sistem saat menerima callback atau notifikasi pembayaran

#### Rencana Penerapan pada Project

Midtrans direncanakan untuk:

- Halaman checkout
- Halaman pembayaran
- Status pembayaran
- Verifikasi pembayaran admin
- Invoice transaksi

#### Cara Install

```bash
composer require midtrans/midtrans-php
```

#### Contoh Konfigurasi `.env`

```env
MIDTRANS_SERVER_KEY=server_key_midtrans
MIDTRANS_CLIENT_KEY=client_key_midtrans
MIDTRANS_IS_PRODUCTION=false
MIDTRANS_IS_SANITIZED=true
MIDTRANS_IS_3DS=true
```

#### Dampak pada Project

- Customer dapat membayar secara online.
- Sistem dapat menerima status pembayaran otomatis.
- Admin lebih mudah melakukan pengecekan pembayaran.
- Invoice dapat diperbarui berdasarkan status pembayaran.

#### Risiko

- API key harus disimpan dengan aman di file `.env`.
- Perlu pengujian menggunakan mode sandbox sebelum production.
- Sistem harus menangani callback pembayaran dengan benar.
- Jika callback gagal, status pembayaran bisa tidak sinkron.

---

### 3.5 Intervention Image

#### Fungsi

Intervention Image adalah package yang digunakan untuk memproses gambar, seperti resize, crop, dan kompres gambar.

#### Alasan Digunakan

Project ini memiliki banyak kebutuhan upload gambar, seperti foto profil, foto homestay, foto souvenir, dan bukti pembayaran. Agar gambar tidak terlalu besar dan website tetap ringan, gambar dioptimasi sebelum disimpan.

#### Pengguna

Dependency ini digunakan oleh:

- Admin saat mengelola data homestay
- Admin saat mengelola data souvenir
- Sistem saat menyimpan gambar upload

#### Penerapan pada Project

Intervention Image diterapkan pada fitur:

- Upload foto profil customer
- Upload foto homestay
- Upload foto souvenir
- Upload bukti pembayaran
- Optimasi ukuran gambar ke format WebP

Pada kode saat ini, Intervention Image digunakan melalui `ImageUploadService`. Service ini membaca file upload, melakukan `scaleDown`, mengubah hasil menjadi format WebP, lalu menyimpan file ke folder upload project.

#### Cara Install

```bash
composer require intervention/image-laravel
```

#### Dampak pada Project

- Ukuran gambar dapat diperkecil.
- Website menjadi lebih ringan.
- Storage lebih hemat.
- Tampilan katalog homestay dan souvenir menjadi lebih rapi.
- Bukti pembayaran tetap disimpan sebagai gambar, tetapi ukuran file lebih terkendali.

#### Risiko

- Perlu menentukan standar ukuran gambar.
- Perlu validasi tipe file seperti jpg, jpeg, png, dan webp.
- Jika kualitas kompresi terlalu rendah, gambar bisa terlihat pecah.

---

### 3.6 Font Awesome

#### Fungsi

Font Awesome adalah library icon berbasis CSS dan SVG yang digunakan untuk menambahkan icon pada tampilan website.

#### Alasan Digunakan

Font Awesome digunakan agar tampilan website lebih menarik dan mudah dipahami oleh pengguna. Icon dapat membantu memperjelas fungsi menu, tombol, dan informasi pada dashboard.

#### Pengguna

Dependency ini digunakan oleh seluruh pengguna website, baik admin maupun customer.

#### Rencana Penerapan pada Project

Font Awesome direncanakan untuk:

- Sidebar dashboard
- Navbar
- Footer
- Tombol tambah, edit, hapus, detail
- Icon sosial media
- Icon fasilitas homestay
- Icon kategori souvenir

#### Cara Integrasi Menggunakan CDN

```html
<link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
/>
```

#### Contoh Penggunaan

```html
<i class="fa-solid fa-house"></i>
<i class="fa-solid fa-cart-shopping"></i>
<i class="fa-solid fa-file-invoice"></i>
```

#### Dampak pada Project

- Tampilan website lebih menarik.
- Menu dan tombol lebih mudah dikenali.
- Dashboard terlihat lebih modern.

#### Risiko

- Jika menggunakan CDN, icon membutuhkan koneksi internet.
- Terlalu banyak icon dapat membuat tampilan terlihat ramai.
- Perlu konsistensi gaya icon agar UI tetap rapi.

---

### 3.7 Tailwind CSS

#### Fungsi

Tailwind CSS adalah framework CSS utility-first yang digunakan untuk membuat tampilan website secara cepat, responsive, dan modern.

#### Alasan Digunakan

Project ini membutuhkan tampilan website yang rapi dan mudah dikembangkan. Tailwind CSS memudahkan developer membuat halaman seperti dashboard, katalog, detail kamar, checkout, invoice, dan halaman admin tanpa menulis CSS terlalu banyak.

#### Pengguna

Dependency ini digunakan oleh developer frontend dalam proses pembuatan tampilan website.

#### Penerapan pada Project

Tailwind CSS diterapkan pada:

- Halaman login dan register
- Dashboard admin
- Dashboard customer
- Halaman katalog homestay
- Halaman katalog souvenir
- Halaman detail kamar
- Halaman checkout
- Halaman invoice
- Tabel data admin
- Form input data

#### Cara Install

```bash
npm install tailwindcss @tailwindcss/vite
```

#### Dampak pada Project

- Tampilan website lebih cepat dibuat.
- Desain lebih responsive.
- Komponen UI lebih mudah dikembangkan.
- Cocok digunakan bersama Laravel Blade.

#### Risiko

- Class Tailwind bisa terlalu panjang jika tidak dikelola dengan baik.
- Perlu konsistensi desain antar halaman.
- Developer harus memahami utility class Tailwind.

---

## 4. Dependency Bawaan Laravel

### 4.1 Laravel Validation

#### Fungsi

Laravel Validation digunakan untuk memvalidasi input form sebelum data disimpan ke database.

#### Alasan Digunakan

Project ini memiliki banyak form input, seperti register, login, booking homestay, checkout, pembayaran, tambah kamar, tambah souvenir, dan laporan. Validasi dibutuhkan agar data yang masuk sesuai format.

#### Contoh Penerapan

Validasi dapat digunakan pada form:

- Register user
- Login
- Booking homestay
- Checkout souvenir
- Upload gambar
- Tambah data kamar
- Tambah data souvenir
- Verifikasi pembayaran

#### Contoh Kode

```php
$request->validate([
    'nama' => 'required|string|max:255',
    'email' => 'required|email',
    'tanggal_checkin' => 'required|date',
    'tanggal_checkout' => 'required|date|after:tanggal_checkin',
]);
```

#### Dampak pada Project

- Data yang masuk lebih aman.
- Mengurangi kesalahan input.
- Mencegah data kosong atau tidak sesuai format.
- Membantu menjaga kualitas data pada database.

#### Risiko

- Rule validasi harus disesuaikan dengan kebutuhan setiap form.
- Pesan error harus dibuat jelas agar mudah dipahami user.

---

### 4.2 Laravel File Storage

#### Fungsi

Laravel File Storage digunakan untuk menyimpan dan mengelola file upload pada project Laravel, terutama file yang disimpan melalui disk `public`.

#### Alasan Digunakan

Project ini membutuhkan upload file gambar untuk foto profil dan bukti pembayaran. Untuk foto homestay dan souvenir, project menyimpan file pada folder `public/uploads` agar tetap kompatibel dengan tampilan katalog yang memakai `asset($foto)`.

#### Contoh Penerapan

File Storage digunakan pada:

- Upload foto profil
- Upload bukti pembayaran
- Penyimpanan file upload pada disk `public`

#### Contoh Kode

```php
$path = $request->file('foto_profil')->store('uploads/foto_profil', 'public');
```

#### Perintah Storage Link

```bash
php artisan storage:link
```

#### Dampak pada Project

- File upload tersimpan lebih terstruktur.
- Gambar mudah dipanggil di halaman website.
- File dapat dipisahkan berdasarkan folder fitur.

#### Risiko

- Folder storage harus memiliki permission yang benar.
- Perlu validasi ukuran dan tipe file.
- Jika file lama tidak dihapus, storage bisa cepat penuh.

---

## 5. Kendala Implementasi Dependency

### 5.1 Kendala Laravel Breeze

Kendala yang mungkin terjadi saat menggunakan Laravel Breeze:

- Tampilan default belum sesuai dengan desain project.
- Redirect setelah login belum membedakan admin dan customer.
- Route dashboard bawaan perlu disesuaikan.

Solusi:

- Menyesuaikan tampilan login dan register menggunakan Tailwind CSS.
- Membuat pengecekan role setelah login.
- Membuat dashboard terpisah untuk admin dan customer.

---

### 5.2 Kendala Spatie Laravel Permission

Kendala yang mungkin terjadi:

- Role belum tersedia di database.
- Error saat assign role karena trait `HasRoles` belum ditambahkan.
- Middleware role belum terbaca.
- User bisa gagal diarahkan ke dashboard sesuai role.

Solusi:

- Menambahkan trait `HasRoles` pada model `User`.
- Membuat `RoleSeeder`.
- Menjalankan seeder role sebelum mencoba register.
- Membersihkan cache permission dengan perintah:

```bash
php artisan optimize:clear
```

---

### 5.3 Kendala Laravel DomPDF

Kendala yang mungkin terjadi:

- Tampilan PDF tidak sama persis dengan tampilan web.
- CSS kompleks tidak terbaca sempurna.
- Generate PDF lambat jika data terlalu banyak.

Solusi:

- Membuat template Blade khusus untuk PDF.
- Menggunakan desain invoice yang sederhana.
- Membatasi data laporan berdasarkan tanggal atau filter tertentu.

---

### 5.4 Kendala Midtrans Payment Gateway

Kendala yang mungkin terjadi:

- API key belum dikonfigurasi.
- Callback pembayaran belum berjalan.
- Status pembayaran tidak berubah otomatis.
- Mode sandbox dan production tertukar.

Solusi:

- Menyimpan API key pada file `.env`.
- Membuat route khusus callback Midtrans.
- Menguji pembayaran menggunakan mode sandbox.
- Memastikan status transaksi diperbarui di database.

---

### 5.5 Kendala Intervention Image

Kendala yang mungkin terjadi:

- File gambar terlalu besar.
- Format gambar tidak sesuai.
- Hasil kompresi terlalu rendah.
- Gambar gagal tersimpan ke storage.

Solusi:

- Menentukan batas ukuran file upload.
- Memvalidasi tipe file.
- Mengatur ukuran resize yang sesuai.
- Memastikan folder storage sudah terhubung dengan `php artisan storage:link`.

---

## 6. Kesimpulan

Dependency/package Laravel pada project **Sistem Informasi Manajemen Homestay dan Penjualan Souvenir Berbasis Web pada Natasha Homestay & Harau Souvenir** digunakan untuk mendukung kebutuhan fitur utama sistem.

Dependency seperti **Laravel Breeze** digunakan sebagai package autentikasi pendukung, **Spatie Laravel Permission** digunakan untuk mengatur role dan hak akses, **Laravel DomPDF** digunakan untuk mengunduh laporan admin dalam format PDF, **Intervention Image** digunakan untuk optimasi gambar upload, dan **Tailwind CSS** digunakan untuk membangun tampilan frontend yang responsive dan modern. Dependency seperti **Midtrans Payment Gateway** dan **Font Awesome** masih dapat ditambahkan pada sprint berikutnya sesuai kebutuhan fitur.

Dengan penggunaan dependency yang tepat, proses pengembangan sistem dapat menjadi lebih cepat, rapi, aman, dan mudah dikembangkan oleh anggota tim.
