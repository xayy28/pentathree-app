# GitHub Actions Documentation

Dokumen ini menjelaskan konfigurasi Continuous Integration (CI) menggunakan GitHub Actions pada project **pentathree-app**.

Project ini merupakan sistem informasi manajemen homestay dan penjualan souvenir berbasis web pada **Natasha Homestay & Harau Souvenir**.

---

## Daftar Isi

- [1. Apa itu GitHub Actions?](#1-apa-itu-github-actions)
- [2. Tujuan CI pada Project Ini](#2-tujuan-ci-pada-project-ini)
- [3. Konfigurasi Workflow](#3-konfigurasi-workflow)
- [4. Cara Kerja Workflow](#4-cara-kerja-workflow)
- [5. Konfigurasi Environment Testing](#5-konfigurasi-environment-testing)
- [6. Menjalankan Test Secara Lokal](#6-menjalankan-test-secara-lokal)
- [7. Contoh Test yang Digunakan](#7-contoh-test-yang-digunakan)
- [8. Status Badge](#8-status-badge)
- [9. Riwayat CI Run](#9-riwayat-ci-run)

---

## 1. Apa itu GitHub Actions?

GitHub Actions adalah fitur otomatisasi dari GitHub yang digunakan untuk menjalankan proses tertentu secara otomatis ketika terjadi perubahan pada repository.

Dalam project ini, GitHub Actions digunakan untuk menjalankan proses **Continuous Integration (CI)**, yaitu proses pengecekan otomatis untuk memastikan project Laravel masih dapat diinstall, dibuild, dan ditest setelah ada perubahan kode.

---

## 2. Tujuan CI pada Project Ini

Tujuan penggunaan GitHub Actions pada project **pentathree-app** adalah:

1. Memastikan kode yang di-push tidak menyebabkan error pada project.
2. Memastikan dependency PHP dapat diinstall menggunakan Composer.
3. Memastikan dependency frontend dapat diinstall menggunakan NPM.
4. Memastikan asset frontend dapat dibuild menggunakan Vite.
5. Menjalankan automated test Laravel.
6. Membantu tim mendeteksi error sebelum perubahan kode digabungkan ke branch utama.
7. Menjaga kualitas kode pada branch `main` dan `testing`.

---

## 3. Konfigurasi Workflow

Workflow GitHub Actions disimpan pada folder:

```text
.github/workflows/
```

File workflow yang digunakan:

```text
test.yml
```

Workflow ini memiliki nama:

```yaml
name: Simple CI
```

Workflow akan berjalan otomatis ketika terjadi:

- `push` ke branch `main`
- `push` ke branch `testing`
- `pull_request` ke branch `main`
- `pull_request` ke branch `testing`

---

## 3.1 Isi Workflow

Berikut konfigurasi workflow yang digunakan pada project:

```yaml
name: Simple CI

on:
    push:
        branches: [main, testing]
    pull_request:
        branches: [main, testing]

jobs:
    build-and-test:
        runs-on: ubuntu-latest

        steps:
            - name: 📥 Checkout code
              uses: actions/checkout@v4

            - name: 🐘 Setup PHP
              uses: shivammathur/setup-php@v2
              with:
                  php-version: "8.4"

            - name: 📦 Install PHP Dependencies
              run: composer install --ignore-platform-reqs --no-interaction --prefer-dist --no-progress

            - name: 📦 Install Node Dependencies & Build
              run: |
                  npm install
                  npm run build

            - name: 🔧 Setup Environment
              run: |
                  cp .env.example .env
                  php artisan key:generate

            - name: ✅ Run Tests
              env:
                  APP_ENV: testing
                  DB_CONNECTION: sqlite
                  DB_DATABASE: ":memory:"
                  SESSION_DRIVER: array
                  CACHE_STORE: array
                  QUEUE_CONNECTION: sync
                  MAIL_MAILER: log
              run: php artisan test
```

---

## 3.2 Catatan Konfigurasi

Pada workflow ini, project menggunakan:

| Bagian           | Konfigurasi          |
| ---------------- | -------------------- |
| Operating System | `ubuntu-latest`      |
| PHP Version      | `8.4`                |
| Node Dependency  | `npm install`        |
| Frontend Build   | `npm run build`      |
| Testing Command  | `php artisan test`   |
| Database Testing | SQLite `:memory:`    |
| Branch Trigger   | `main` dan `testing` |

---

## 4. Cara Kerja Workflow

Workflow berjalan dengan tahapan berikut:

|  No | Step                              | Penjelasan                                                         |
| --: | --------------------------------- | ------------------------------------------------------------------ |
|   1 | Checkout code                     | Mengambil kode terbaru dari repository                             |
|   2 | Setup PHP                         | Menyiapkan PHP versi 8.4 untuk menjalankan Laravel                 |
|   3 | Install PHP Dependencies          | Menginstall dependency Laravel menggunakan Composer                |
|   4 | Install Node Dependencies & Build | Menginstall dependency frontend dan menjalankan build Vite         |
|   5 | Setup Environment                 | Menyalin `.env.example` menjadi `.env` dan membuat application key |
|   6 | Run Tests                         | Menjalankan seluruh test Laravel menggunakan `php artisan test`    |

Jika semua step berhasil, workflow akan berstatus **pass**.

Jika salah satu step gagal, workflow akan berstatus **failed** dan detail error dapat dilihat pada tab **Actions** di GitHub.

---

## 5. Konfigurasi Environment Testing

Pada project lokal, konfigurasi database menggunakan MySQL:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pentathree_app
DB_USERNAME=root
DB_PASSWORD=
```

Namun pada GitHub Actions, database testing menggunakan SQLite memory:

```yaml
DB_CONNECTION: sqlite
DB_DATABASE: ":memory:"
```

SQLite digunakan agar proses testing lebih ringan dan tidak perlu menjalankan service MySQL tambahan pada server GitHub Actions.

Selain itu, beberapa konfigurasi testing dibuat lebih sederhana:

```yaml
SESSION_DRIVER: array
CACHE_STORE: array
QUEUE_CONNECTION: sync
MAIL_MAILER: log
```

Tujuannya agar test tidak bergantung pada database session, queue database, cache database, atau mail server.

---

## 6. Menjalankan Test Secara Lokal

Sebelum melakukan push atau membuat pull request, test dapat dijalankan secara lokal menggunakan perintah:

```bash
php artisan test
```

Jika ingin memastikan dependency sudah lengkap, jalankan:

```bash
composer install
npm install
npm run build
php artisan test
```

Jika terjadi error karena cache Laravel, jalankan:

```bash
php artisan optimize:clear
```

---

## 7. Contoh Test yang Digunakan

Project saat ini memiliki test dasar menggunakan Pest.

### 7.1 Unit Test

Contoh test sederhana:

```php
<?php

test('that true is true', function () {
    expect(true)->toBeTrue();
});
```

Test ini memastikan bahwa konfigurasi Pest/Laravel testing dapat berjalan dengan benar.

---

### 7.2 Feature Test

Karena halaman utama `/` akan mengarahkan user yang belum login ke halaman login, maka test yang sesuai adalah:

```php
<?php

test('guest is redirected to login from homepage', function () {
    $response = $this->get('/');

    $response->assertRedirect(route('login'));
});
```

Test ini memastikan bahwa user yang belum login tidak langsung masuk ke dashboard, tetapi diarahkan ke halaman login.

---

## 8. Status Badge

Badge workflow dapat ditambahkan ke file `README.md` agar status CI terlihat langsung pada halaman repository.

```markdown
![Simple CI](https://github.com/xayy28/pentathree-app/actions/workflows/test.yml/badge.svg)
```

Badge tersebut akan menunjukkan status workflow terakhir, apakah berhasil atau gagal.

---

## 9. Riwayat CI Run

| Tanggal | Branch | Workflow | Status | Keterangan             |
| ------- | ------ | -------- | ------ | ---------------------- |
| —       | —      | —        | —      | Belum ada run tercatat |

> Riwayat CI dapat diisi setelah workflow pertama kali dijalankan pada repository GitHub.
