# Installation Documentation

Dokumen ini menjelaskan langkah-langkah instalasi project **pentathree-app** berbasis Laravel.

Project ini merupakan sistem informasi manajemen homestay dan penjualan souvenir berbasis web pada **Natasha Homestay & Harau Souvenir**.

---

## Daftar Isi

- [1. Persyaratan Sistem](#1-persyaratan-sistem)
- [2. Clone Repository](#2-clone-repository)
- [3. Install Dependency](#3-install-dependency)
- [4. Konfigurasi Environment](#4-konfigurasi-environment)
- [5. Konfigurasi Database](#5-konfigurasi-database)
- [6. Migrasi dan Seeder Database](#6-migrasi-dan-seeder-database)
- [7. Konfigurasi Storage](#7-konfigurasi-storage)
- [8. Menjalankan Project](#8-menjalankan-project)
- [9. Git Workflow](#9-git-workflow)
- [10. Troubleshooting](#10-troubleshooting)

---

## 1. Persyaratan Sistem

Sebelum menjalankan project, pastikan perangkat sudah memiliki kebutuhan berikut:

| Kebutuhan          | Versi Minimum | Keterangan                                      |
| ------------------ | ------------: | ----------------------------------------------- |
| PHP                |          8.2+ | Disarankan mengikuti versi pada `composer.json` |
| Composer           |           2.x | Dependency manager PHP                          |
| Node.js            |   18.x / 20.x | Untuk menjalankan Vite dan asset frontend       |
| NPM                |          9.x+ | Biasanya sudah terinstall bersama Node.js       |
| MySQL              |           8.0 | Database utama project                          |
| Git                |           2.x | Untuk clone, pull, commit, dan push repository  |
| XAMPP / Laragon    |       Terbaru | Untuk menjalankan Apache/MySQL lokal            |
| Visual Studio Code |       Terbaru | Code editor                                     |
| Browser            |       Terbaru | Chrome, Edge, Firefox, dan sejenisnya           |

---

## 2. Clone Repository

Clone repository dari GitHub ke perangkat lokal:

```bash
git clone https://github.com/xayy28/pentathree-app.git
```

Masuk ke folder project:

```bash
cd pentathree-app
```

---

## 3. Install Dependency

Project Laravel membutuhkan dependency dari **Composer** dan **NPM**.

### 3.1 Install Dependency PHP

Jalankan perintah berikut:

```bash
composer install
```

Jika terjadi error karena perbedaan versi PHP, gunakan:

```bash
composer install --ignore-platform-reqs
```

> Gunakan `--ignore-platform-reqs` hanya jika benar-benar diperlukan.

---

### 3.2 Install Dependency Frontend

Jalankan perintah berikut:

```bash
npm install
```

Dependency frontend digunakan untuk menjalankan asset seperti Tailwind CSS, Vite, JavaScript, dan CSS project.

---

## 4. Konfigurasi Environment

### 4.1 Salin File `.env`

Salin file `.env.example` menjadi `.env`.

Untuk Windows PowerShell:

```powershell
Copy-Item .env.example .env
```

Untuk Linux / macOS / Git Bash:

```bash
cp .env.example .env
```

---

### 4.2 Generate Application Key

Generate application key Laravel:

```bash
php artisan key:generate
```

Application key digunakan Laravel untuk kebutuhan enkripsi aplikasi.

---

### 4.3 Konfigurasi File `.env`

Buka file `.env`, lalu sesuaikan bagian berikut:

```env
APP_NAME="PentaThree App"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pentathree_app
DB_USERNAME=root
DB_PASSWORD=

FILESYSTEM_DISK=public
```

Pastikan `APP_KEY` sudah terisi setelah menjalankan:

```bash
php artisan key:generate
```

---

## 5. Konfigurasi Database

### 5.1 Buat Database MySQL

Buka phpMyAdmin melalui browser:

```text
http://localhost/phpmyadmin
```

Buat database baru dengan nama:

```text
pentathree_app
```

Atau gunakan query SQL berikut:

```sql
CREATE DATABASE pentathree_app;
```

Pastikan nama database sama dengan konfigurasi pada file `.env`:

```env
DB_DATABASE=pentathree_app
```

---

### 5.2 Pastikan MySQL Berjalan

Jika menggunakan XAMPP, pastikan service berikut sudah aktif:

- Apache
- MySQL

Jika menggunakan Laragon, pastikan server sudah dijalankan.

---

## 6. Migrasi dan Seeder Database

### 6.1 Jalankan Migrasi

Untuk membuat tabel database berdasarkan file migration Laravel, jalankan:

```bash
php artisan migrate
```

---

### 6.2 Jalankan Seeder

Jika project menyediakan seeder, jalankan:

```bash
php artisan db:seed
```

Atau jalankan migration dan seeder sekaligus:

```bash
php artisan migrate --seed
```

Jika ingin mengulang database dari awal:

```bash
php artisan migrate:fresh --seed
```

> Perintah `migrate:fresh --seed` akan menghapus seluruh tabel dan data lama, lalu membuat ulang database dari awal. Gunakan hanya untuk development lokal.

---

## 7. Konfigurasi Storage

Agar file upload dapat diakses melalui folder `public`, jalankan:

```bash
php artisan storage:link
```

Perintah ini akan membuat symbolic link dari:

```text
storage/app/public
```

ke:

```text
public/storage
```

Storage digunakan untuk menyimpan file upload seperti gambar homestay, gambar kamar, gambar souvenir, bukti pembayaran, dan file pendukung lainnya.

---

## 8. Menjalankan Project

Untuk menjalankan project, gunakan dua terminal terpisah.

### Terminal 1 — Jalankan Server Laravel

```bash
php artisan serve
```

Server Laravel akan berjalan pada alamat:

```text
http://127.0.0.1:8000
```

---

### Terminal 2 — Jalankan Vite

```bash
npm run dev
```

Vite digunakan untuk menjalankan asset frontend seperti CSS dan JavaScript.

---

### Akses Project

Buka browser, lalu akses:

```text
http://127.0.0.1:8000
```

---

## 9. Git Workflow

Project ini menggunakan GitHub sebagai version control.

### 9.1 Struktur Branch

| Branch                | Fungsi                                   |
| --------------------- | ---------------------------------------- |
| `main`                | Branch utama / production                |
| `testing`             | Branch integrasi sebelum masuk ke `main` |
| `zackri_kurnia_amri`  | Branch pribadi Zackri Kurnia Amri        |
| `m_aufi_syahyudi`     | Branch pribadi Muhammad Aufi Syahyudi    |
| `yelsa_pagansa_putri` | Branch pribadi Yelsa Pagansa Putri       |
| `zikri_ilham_pratama` | Branch pribadi Zikri Ilham Pratama       |
| `taufiqurrahman`      | Branch pribadi Taufiqurrahman            |

---

### 9.2 Alur Kerja Harian

Sebelum mulai coding, pastikan berada di branch pribadi:

```bash
git checkout nama_branch_kamu
```

Contoh:

```bash
git checkout zackri_kurnia_amri
```

Ambil update terbaru dari branch utama integrasi:

```bash
git pull origin testing
```

Setelah selesai mengerjakan fitur:

```bash
git add .
git commit -m "feat: menambahkan fitur nama-fitur"
git push origin nama_branch_kamu
```

Setelah itu, buat Pull Request dari branch pribadi ke branch `testing`.

---

### 9.3 Konvensi Commit Message

| Prefix      | Fungsi                                              |
| ----------- | --------------------------------------------------- |
| `feat:`     | Menambahkan fitur baru                              |
| `fix:`      | Memperbaiki bug                                     |
| `docs:`     | Mengubah dokumentasi                                |
| `style:`    | Mengubah tampilan tanpa mengubah logic              |
| `refactor:` | Merapikan kode tanpa mengubah fitur                 |
| `test:`     | Menambah atau memperbaiki pengujian                 |
| `chore:`    | Perubahan konfigurasi, dependency, atau maintenance |

Contoh commit:

```bash
git commit -m "feat: menambahkan halaman login"
git commit -m "fix: memperbaiki validasi form register"
git commit -m "docs: memperbarui installation documentation"
```

---

## 10. Troubleshooting

### 10.1 Error `APP_KEY` Belum Ada

Jika muncul error seperti:

```text
No application encryption key has been specified.
```

Jalankan:

```bash
php artisan key:generate
```

---

### 10.2 Error Koneksi Database

Jika terjadi error koneksi database, cek beberapa hal berikut:

- MySQL sudah berjalan.
- Database `pentathree_app` sudah dibuat.
- Konfigurasi `.env` sudah benar.
- Username dan password database sesuai.

Contoh konfigurasi database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pentathree_app
DB_USERNAME=root
DB_PASSWORD=
```

Setelah mengubah `.env`, jalankan:

```bash
php artisan config:clear
```

---

### 10.3 Error `Class not found`

Jika muncul error `Class not found`, jalankan:

```bash
composer dump-autoload
```

Jika masih error, coba jalankan ulang:

```bash
composer install
```

---

### 10.4 Error CSS atau JavaScript Tidak Tampil

Jika tampilan website berantakan atau CSS tidak muncul, jalankan:

```bash
npm install
npm run dev
```

Jika untuk production:

```bash
npm run build
```

Lalu refresh browser menggunakan:

```text
Ctrl + Shift + R
```

---

### 10.5 Error `Vite manifest not found`

Jika muncul error:

```text
Vite manifest not found
```

Jalankan:

```bash
npm run dev
```

Atau untuk build production:

```bash
npm run build
```

---

### 10.6 Error Storage / Gambar Tidak Tampil

Jika gambar upload tidak tampil, jalankan:

```bash
php artisan storage:link
```

Jika symbolic link sudah ada tetapi masih bermasalah, hapus link lama lalu buat ulang.

Untuk Windows PowerShell:

```powershell
Remove-Item public/storage
php artisan storage:link
```

Untuk Linux / macOS / Git Bash:

```bash
rm public/storage
php artisan storage:link
```

---

### 10.7 Error Saat `composer install`

Jika Composer gagal install dependency karena versi PHP tidak sesuai:

```bash
composer install --ignore-platform-reqs
```

Jika muncul error SSL Composer, coba:

```bash
composer clear-cache
composer install
```

---

### 10.8 Perubahan Setelah Pull Tidak Muncul

Jika setelah `git pull` perubahan belum muncul, jalankan:

```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
```

Jika ada perubahan dependency setelah pull, jalankan:

```bash
composer install
npm install
```

Jika ada perubahan database, jalankan:

```bash
php artisan migrate
```

---

## 11. Perintah Singkat Instalasi

Berikut versi singkat untuk menjalankan project dari awal:

```bash
git clone https://github.com/xayy28/pentathree-app.git
cd pentathree-app
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan storage:link
php artisan serve
```

Lalu buka terminal kedua:

```bash
npm run dev
```

Akses project melalui browser:

```text
http://127.0.0.1:8000
```

---

## 12. Catatan

Jika project menggunakan fitur tambahan seperti role permission, invoice PDF, payment gateway, dan upload gambar, pastikan semua dependency sudah terinstall melalui:

```bash
composer install
npm install
```

Jika database membutuhkan data awal seperti role admin dan customer, pastikan seeder sudah dijalankan:

```bash
php artisan db:seed
```

Atau:

```bash
php artisan migrate:fresh --seed
```
