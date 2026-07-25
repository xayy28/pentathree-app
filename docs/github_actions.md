# Dokumentasi GitHub Actions

Terakhir diperbarui: 2026-07-26

Dokumen ini menjelaskan workflow CI/CD yang dipakai pada project PentaThree SIMHOSUV berdasarkan kondisi repository terbaru.

## 1. Tujuan

GitHub Actions dipakai untuk memastikan kode aman sebelum masuk ke branch `testing`.

Workflow yang aktif:
- `.github/workflows/test-before-merge.yml`
- `.github/workflows/code-linting.yml`

Trigger utama kedua workflow:
```yaml
on:
  pull_request:
    branches:
      - testing
```

Artinya workflow berjalan saat ada pull request ke branch `testing`.

## 2. Workflow: Automasi Testing Sebelum Merge

**File:** `.github/workflows/test-before-merge.yml`

**Nama:** Automasi Testing Sebelum Merge

**Trigger:** Pull Request ke branch `testing`

**Jobs:**
1. Checkout repository (`actions/checkout@v4`)
2. Setup PHP 8.4 (`shivammathur/setup-php@v2`) — extensions: mbstring, pdo, pdo_sqlite, fileinfo, openssl, tokenizer, xml, ctype, json
3. Install Composer dependencies (`composer install --no-interaction --prefer-dist --no-progress`)
4. Copy `.env.example` ke `.env`
5. Generate `APP_KEY`
6. Setup Node.js 20 (`actions/setup-node@v4`)
7. Install NPM dependencies (`npm ci`)
8. Build Vite assets (`npm run build`)
9. Clear Laravel cache (`php artisan optimize:clear`)
10. Run Laravel tests (`php artisan test`)

**Environment CI:**
```yaml
DB_CONNECTION: sqlite
DB_DATABASE: ":memory:"
CACHE_STORE: array
SESSION_DRIVER: array
QUEUE_CONNECTION: sync
```

**Catatan:**
- SQLite in-memory: test lebih cepat, tidak perlu MySQL di CI
- Queue sync: job dijalankan langsung, tidak perlu worker
- Midtrans test: menggunakan Mockery untuk Snap token dan payload webhook — tidak perlu API asli
- DomPDF test: hanya cek bahwa response diawali `%PDF`

## 3. Workflow: Code Linting

**File:** `.github/workflows/code-linting.yml`

**Nama:** Code Linting

**Trigger:** Pull Request ke branch `testing`

**Jobs:**
1. Checkout repository
2. Setup PHP 8.4 — extensions: mbstring, fileinfo, openssl, tokenizer, xml, ctype, json
3. Check PHP syntax pada `app`, `routes`, `database`, `tests`
4. Setup Node.js 20
5. Install Stylelint + stylelint-config-recommended
6. Buat konfigurasi Stylelint sementara (.stylelintrc.json)
7. Check CSS files di `resources/**/*.css`

**Command penting:**
```bash
find app routes database tests -name "*.php" -print0 | xargs -0 -n1 php -l
stylelint "resources/**/*.css" --allow-empty-input
```

**Catatan:**
- Workflow ini tidak menjalankan Pint atau git diff --check
- CSS check menggunakan `--allow-empty-input` agar tidak error jika folder resources/css kosong

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

## 5. Catatan Mailtrap di CI

CI menggunakan `QUEUE_CONNECTION=sync` dan tidak mengirim email sungguhan. Email verification test menggunakan Mockery atau Laravel `Notification::fake()`. Tidak perlu konfigurasi Mailtrap di GitHub Actions.

## 6. Catatan Midtrans di CI

Test Midtrans menggunakan Mockery:
- Mock Snap token creation (tidak memanggil API Midtrans)
- Mock webhook payload dengan signature yang benar
- `MIDTRANS_SERVER_KEY` dan `MIDTRANS_CLIENT_KEY` tidak perlu diisi asli

## 7. Catatan Environment

Workflow menyalin `.env.example` → `.env`. Pastikan `.env.example`:
- Tidak berisi key Midtrans asli
- Tidak berisi credential database asli
- Kompatibel dengan SQLite in-memory (array cache, array session, sync queue)

## 8. Kapan Workflow Gagal

Workflow bisa gagal karena:
- Dependency Composer gagal install
- Dependency NPM tidak sinkron dengan `package-lock.json`
- Test gagal
- Build Vite gagal
- Syntax PHP error
- File CSS melanggar rule Stylelint
- `.env.example` tidak kompatibel dengan environment CI (misal butuh MySQL)

**Langkah perbaikan:**
1. Jalankan `php artisan test` di lokal
2. Jalankan `npm run build`
3. Jalankan `vendor\bin\pint --dirty`
4. Cek error detail di tab Actions GitHub
5. Perbaiki test atau konfigurasi yang gagal

## 9. Rekomendasi Perbaikan Workflow

Untuk final PBL, rekomendasi:
- Tambahkan step Pint ke workflow linting: `vendor/bin/pint --test`
- Tambahkan `git diff --check` ke workflow testing
- Pastikan `.env.example` tidak berisi key asli Midtrans atau credential Mailtrap

## 10. Kesimpulan

CI project saat ini sudah layak untuk PBL:
- Testing Laravel berjalan otomatis di Pull Request ke branch testing
- Build Vite berjalan otomatis
- Syntax PHP dan CSS dicek
- Semua service external di-mock, tidak perlu koneksi asli
- Workflow dapat dijadikan bukti bahwa project memiliki proses CI sebelum merge
