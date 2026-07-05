# Dokumentasi GitHub Actions

Terakhir diperbarui: 2026-07-02

Dokumen ini menjelaskan workflow CI/CD yang dipakai pada project PentaThree SIMHOSUV berdasarkan kondisi repository terbaru.

## 1. Tujuan

GitHub Actions dipakai untuk memastikan kode aman sebelum masuk ke branch `testing`.

Workflow yang aktif:

- `.github/workflows/test-before-merge.yml`
- `.github/workflows/code-linting.yml`

Trigger utama:

```yaml
on:
  pull_request:
    branches:
      - testing
```

Artinya workflow berjalan saat ada pull request ke branch `testing`.

## 2. Workflow Testing Sebelum Merge

File:

```text
.github/workflows/test-before-merge.yml
```

Nama workflow:

```text
Automasi Testing Sebelum Merge
```

Step utama:

1. Checkout repository.
2. Setup PHP 8.4.
3. Install dependency Composer.
4. Copy `.env.example` ke `.env`.
5. Generate `APP_KEY`.
6. Setup Node.js 20.
7. Install dependency NPM dengan `npm ci`.
8. Build asset Vite dengan `npm run build`.
9. Clear cache Laravel.
10. Jalankan test dengan `php artisan test`.

Environment test:

```yaml
DB_CONNECTION: sqlite
DB_DATABASE: ":memory:"
CACHE_STORE: array
SESSION_DRIVER: array
QUEUE_CONNECTION: sync
```

Alasan memakai SQLite memory:

- Test lebih cepat.
- Tidak perlu database MySQL di GitHub Actions.
- Database dibuat ulang setiap run test.

## 3. Workflow Code Linting

File:

```text
.github/workflows/code-linting.yml
```

Nama workflow:

```text
Code Linting
```

Step utama:

1. Checkout repository.
2. Setup PHP 8.4.
3. Cek syntax PHP pada folder `app`, `routes`, `database`, dan `tests`.
4. Setup Node.js 20.
5. Install Stylelint.
6. Buat konfigurasi Stylelint sementara.
7. Cek file CSS di `resources/**/*.css`.

Command penting:

```bash
find app routes database tests -name "*.php" -print0 | xargs -0 -n1 php -l
stylelint "resources/**/*.css" --allow-empty-input
```

## 4. Quality Gate Lokal

Sebelum push atau membuat pull request, jalankan command ini di lokal:

```bash
composer install
npm install
php artisan test
vendor\bin\pint --dirty
npm run build
git diff --check
```

Status terakhir setelah Sprint 8:

```text
php artisan test        = 86 passed
vendor\bin\pint --dirty = passed
npm run build           = passed
git diff --check        = clean
```

## 5. Catatan Dependency CI

Dependency backend:

- PHP 8.3 minimal sesuai `composer.json`.
- Workflow saat ini memakai PHP 8.4 dan masih kompatibel.
- Composer install wajib sukses.

Dependency frontend:

- Node.js 20.
- `npm ci` untuk install sesuai `package-lock.json`.
- `npm run build` untuk memastikan asset Vite bisa dibuild.

Dependency test:

- Pest.
- PHPUnit bawaan dependency Pest.
- SQLite in-memory.

## 6. Catatan Midtrans di CI

Test Midtrans di repository memakai mock untuk Snap token dan payload signed untuk webhook. CI tidak perlu memanggil API Midtrans asli.

Yang perlu dijaga:

- Jangan commit server key Production.
- `.env.example` sebaiknya memakai placeholder, bukan key asli.
- Jika test membutuhkan config Midtrans, gunakan value palsu seperti `Mid-server-test` dan `Mid-client-test`.

## 7. Catatan DomPDF di CI

DomPDF dipakai untuk test laporan PDF.

Test yang relevan:

```text
tests/Feature/LaporanTest.php
```

Hal yang dicek:

- Route laporan hanya bisa diakses admin.
- Filter laporan benar.
- Response download PDF benar-benar diawali `%PDF`.

## 8. Kapan Workflow Gagal

Workflow bisa gagal karena:

- Dependency Composer gagal install.
- Dependency NPM tidak sinkron dengan `package-lock.json`.
- Test gagal.
- Build Vite gagal.
- Syntax PHP error.
- File CSS melanggar rule Stylelint.
- `.env.example` tidak kompatibel dengan environment CI.

Langkah perbaikan:

1. Jalankan `php artisan test` di lokal.
2. Jalankan `npm run build`.
3. Jalankan `vendor\bin\pint --dirty`.
4. Cek error detail di tab Actions.
5. Perbaiki test atau konfigurasi yang gagal.

## 9. Rekomendasi Perbaikan Workflow

Rekomendasi sebelum project final:

- Tambahkan step Pint ke workflow linting:

```yaml
- name: Run Laravel Pint
  run: vendor/bin/pint --test
```

- Tambahkan `git diff --check` untuk mencegah trailing whitespace:

```yaml
- name: Check whitespace
  run: git diff --check
```

- Pastikan `.env.example` tidak berisi key asli Midtrans.

## 10. Kesimpulan

CI project saat ini sudah cukup untuk menjaga kualitas Sprint 8:

- Test Laravel jalan otomatis.
- Build Vite jalan otomatis.
- Syntax PHP dicek.
- CSS dicek.

Untuk final PBL, workflow ini sudah layak dipakai sebagai bukti bahwa project punya proses testing sebelum merge.
