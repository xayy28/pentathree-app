# Refactoring Documentation

Dokumen ini mencatat keputusan refactoring yang dilakukan dan direncanakan selama pengembangan project **pentathree-app**.

Project ini merupakan sistem informasi manajemen homestay dan penjualan souvenir berbasis web pada **Natasha Homestay & Harau Souvenir**.

Refactoring dilakukan untuk membuat struktur kode lebih rapi, mudah dibaca, mudah dikembangkan, dan mengurangi duplikasi kode.

---

## Daftar Isi

- [1. Apa itu Refactoring?](#1-apa-itu-refactoring)
- [2. Tujuan Refactoring](#2-tujuan-refactoring)
- [3. Kapan Refactoring Dilakukan?](#3-kapan-refactoring-dilakukan)
- [4. Struktur Controller Saat Ini](#4-struktur-controller-saat-ini)
- [5. Kandidat Refactoring](#5-kandidat-refactoring)
- [6. Riwayat Refactoring](#6-riwayat-refactoring)

---

## 1. Apa itu Refactoring?

Refactoring adalah proses memperbaiki struktur internal kode tanpa mengubah fungsi utama aplikasi.

Artinya, tampilan dan fitur aplikasi tetap berjalan seperti sebelumnya, tetapi struktur kode dibuat lebih bersih, rapi, dan mudah dipelihara.

Contoh refactoring:

- Memindahkan validasi dari controller ke FormRequest.
- Mengubah route manual menjadi route group atau resource route.
- Memindahkan logic upload file ke service.
- Menggunakan route model binding agar controller lebih bersih.
- Mengurangi duplikasi kode yang sama di beberapa method.

---

## 2. Tujuan Refactoring

Tujuan refactoring pada project ini adalah:

1. Membuat controller lebih ringan dan tidak terlalu banyak logic.
2. Mengurangi duplikasi validasi dan upload file.
3. Membuat route lebih rapi dan konsisten.
4. Mempermudah maintenance ketika fitur bertambah.
5. Mempermudah anggota tim membaca dan memahami kode.
6. Menjaga struktur project agar sesuai dengan standar Laravel.

---

## 3. Kapan Refactoring Dilakukan?

Refactoring dilakukan ketika:

1. Validasi form masih ditulis langsung di controller.
2. Route mulai terlalu panjang dan berulang.
3. Upload file masih ditangani langsung di controller.
4. Controller memiliki terlalu banyak tanggung jawab.
5. Terdapat kode yang sama di method `store()` dan `update()`.
6. Terdapat closure pada route yang sebaiknya dipindahkan ke controller.
7. Nama route atau struktur URL belum konsisten.
8. Ada feedback dari anggota tim atau hasil review kode.

---

## 4. Struktur Controller Saat Ini

Struktur controller pada project saat ini:

```text
app/Http/Controllers
│   AuthController.php
│   Controller.php
│
├── Auth
├── Homestay
│   └── HomestayController.php
│
├── Laporan
│   └── LaporanController.php
│
├── Pembayaran
│   └── PembayaranController.php
│
├── Reservasi
│   └── ReservasiController.php
│
└── Souvenir
    └── SouvenirController.php
```

Struktur ini sudah cukup baik karena controller sudah dikelompokkan berdasarkan fitur utama, seperti Homestay, Souvenir, Reservasi, Pembayaran, dan Laporan.

Namun, beberapa bagian masih dapat dirapikan agar lebih konsisten dan mudah dikembangkan.

---

# 5. Kandidat Refactoring

---

## 5.1 Refactoring Route dengan Prefix, Name, dan Middleware Group

### Kondisi Saat Ini

Pada file `routes/web.php`, route admin dan user sudah dipisahkan menggunakan middleware `role:admin` dan `role:user`.

Namun, route admin masih ditulis secara manual seperti:

```php
Route::get('/admin/homestay', [HomestayController::class, 'index'])->name('admin.homestay');
Route::get('/admin/homestay/create', [HomestayController::class, 'create'])->name('admin.homestay.create');
Route::post('/admin/homestay', [HomestayController::class, 'store'])->name('admin.homestay.store');
Route::get('/admin/homestay/{homestay_id}/edit', [HomestayController::class, 'edit'])->name('admin.homestay.edit');
Route::put('/admin/homestay/{homestay_id}', [HomestayController::class, 'update'])->name('admin.homestay.update');
Route::delete('/admin/homestay/{homestay_id}', [HomestayController::class, 'destroy'])->name('admin.homestay.destroy');
```

Kode tersebut masih bisa dibuat lebih ringkas dengan `prefix`, `name`, dan `Route::resource()`.

---

### Target Refactoring

Route admin dikelompokkan seperti ini:

```php
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        Route::resource('homestay', HomestayController::class);
        Route::get('/souvenir', [SouvenirController::class, 'index'])->name('souvenir.index');
        Route::get('/reservasi', [ReservasiController::class, 'index'])->name('reservasi.index');
        Route::get('/pembayaran', [PembayaranController::class, 'index'])->name('pembayaran.index');
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    });
```

Route user juga dapat dikelompokkan:

```php
Route::middleware(['auth', 'role:user'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {
        Route::get('/dashboard', function () {
            return view('dashboard');
        })->name('dashboard');

        Route::get('/homestay', [HomestayController::class, 'index'])->name('homestay.index');
        Route::get('/souvenir', [SouvenirController::class, 'index'])->name('souvenir.index');
        Route::get('/reservasi', [ReservasiController::class, 'index'])->name('reservasi.index');
    });
```

---

### Manfaat

- Route menjadi lebih singkat.
- Nama route lebih konsisten.
- Lebih mudah menambah route baru.
- Struktur route admin dan user lebih jelas.

### Prioritas

Tinggi

### Status

Belum dikerjakan

---

## 5.2 Refactoring Dashboard dari Closure ke Controller

### Kondisi Saat Ini

Dashboard admin dan user masih ditulis langsung di route menggunakan closure:

```php
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
```

Untuk tahap awal ini masih boleh, tetapi jika dashboard mulai menampilkan data seperti jumlah homestay, jumlah souvenir, jumlah reservasi, pembayaran, dan laporan, sebaiknya dipindahkan ke controller.

---

### Target Refactoring

Membuat controller baru:

```text
app/Http/Controllers/Dashboard/AdminDashboardController.php
app/Http/Controllers/Dashboard/UserDashboardController.php
```

Contoh:

```php
namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Homestay;
use App\Models\Souvenir;
use App\Models\Reservasi;
use App\Models\Pembayaran;

class AdminDashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'totalHomestay' => Homestay::count(),
            'totalSouvenir' => Souvenir::count(),
            'totalReservasi' => Reservasi::count(),
            'totalPembayaran' => Pembayaran::count(),
        ]);
    }
}
```

Route setelah refactoring:

```php
Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
```

---

### Manfaat

- Dashboard lebih mudah dikembangkan.
- Logic perhitungan data tidak ditulis di route.
- Route menjadi lebih bersih.
- Sesuai prinsip Laravel MVC.

### Prioritas

Sedang

### Status

Belum dikerjakan

---

## 5.3 Refactoring Validasi Homestay ke FormRequest

### Kondisi Saat Ini

Pada `HomestayController`, validasi masih ditulis langsung di method `store()` dan `update()`.

Contoh pada method `store()`:

```php
$request->validate([
    'nama_homestay' => 'required|string|max:255',
    'harga_permalam' => 'required|numeric|min:0',
    'kapasitas' => 'required|integer|min:1',
    'status' => 'required|string|max:50',
    'detail' => 'nullable|string',
    'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
]);
```

Validasi yang sama juga digunakan pada method `update()`. Ini menyebabkan duplikasi kode.

---

### Target Refactoring

Membuat FormRequest khusus:

```text
app/Http/Requests/Homestay/StoreHomestayRequest.php
app/Http/Requests/Homestay/UpdateHomestayRequest.php
```

Contoh:

```php
namespace App\Http\Requests\Homestay;

use Illuminate\Foundation\Http\FormRequest;

class StoreHomestayRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'admin';
    }

    public function rules(): array
    {
        return [
            'nama_homestay' => 'required|string|max:255',
            'harga_permalam' => 'required|numeric|min:0',
            'kapasitas' => 'required|integer|min:1',
            'status' => 'required|string|max:50',
            'detail' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ];
    }
}
```

Controller setelah refactoring:

```php
use App\Http\Requests\Homestay\StoreHomestayRequest;
use App\Http\Requests\Homestay\UpdateHomestayRequest;

public function store(StoreHomestayRequest $request)
{
    $data = $request->validated();

    Homestay::create($data);

    return redirect()->route('admin.homestay.index')
        ->with('success', 'Homestay berhasil ditambahkan.');
}
```

---

### Manfaat

- Controller menjadi lebih bersih.
- Validasi lebih mudah digunakan ulang.
- Rule validasi lebih mudah dikelola.
- Jika ada perubahan validasi, cukup ubah di FormRequest.

### Prioritas

Tinggi

### Status

Belum dikerjakan

---

## 5.4 Refactoring Upload Foto Homestay ke Storage atau Service

### Kondisi Saat Ini

Upload foto pada `HomestayController` masih dilakukan langsung di controller menggunakan:

```php
$file->move(public_path('uploads/homestays'), $filename);
$data['foto'] = 'uploads/homestays/' . $filename;
```

Saat update, file lama dihapus menggunakan:

```php
@unlink(public_path($homestay->foto));
```

Cara ini bisa berjalan, tetapi belum ideal karena logic upload dan hapus file bercampur dengan logic CRUD.

---

### Target Refactoring

Gunakan Laravel Storage:

```php
$path = $request->file('foto')->store('homestays', 'public');
$data['foto'] = $path;
```

Untuk menghapus file lama:

```php
use Illuminate\Support\Facades\Storage;

if ($homestay->foto) {
    Storage::disk('public')->delete($homestay->foto);
}
```

Atau dibuat service khusus:

```text
app/Services/FileUploadService.php
```

Contoh service:

```php
namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileUploadService
{
    public function upload(?UploadedFile $file, string $folder): ?string
    {
        if (! $file) {
            return null;
        }

        return $file->store($folder, 'public');
    }

    public function delete(?string $path): void
    {
        if ($path) {
            Storage::disk('public')->delete($path);
        }
    }
}
```

Controller setelah refactoring:

```php
public function store(StoreHomestayRequest $request, FileUploadService $fileUploadService)
{
    $data = $request->validated();

    if ($request->hasFile('foto')) {
        $data['foto'] = $fileUploadService->upload($request->file('foto'), 'homestays');
    }

    Homestay::create($data);

    return redirect()->route('admin.homestay.index')
        ->with('success', 'Homestay berhasil ditambahkan.');
}
```

---

### Manfaat

- Upload file lebih rapi.
- File tersimpan di storage Laravel.
- Mudah digunakan ulang untuk souvenir, bukti pembayaran, dan gambar lain.
- Tidak perlu menggunakan `public_path()` dan `unlink()` langsung di controller.

### Prioritas

Tinggi

### Status

Belum dikerjakan

---

## 5.5 Refactoring HomestayController Menggunakan Route Model Binding

### Kondisi Saat Ini

Pada method `edit()`, `update()`, dan `destroy()`, pencarian data masih dilakukan manual:

```php
$homestay = Homestay::findOrFail($homestay_id);
```

Parameter route juga masih menggunakan:

```php
{homestay_id}
```

---

### Target Refactoring

Menggunakan Route Model Binding:

```php
public function edit(Homestay $homestay)
{
    return view('homestay.editHomestay', compact('homestay'));
}

public function update(UpdateHomestayRequest $request, Homestay $homestay)
{
    $homestay->update($request->validated());

    return redirect()->route('admin.homestay.index')
        ->with('success', 'Homestay berhasil diperbarui.');
}

public function destroy(Homestay $homestay)
{
    $homestay->delete();

    return redirect()->route('admin.homestay.index')
        ->with('success', 'Homestay berhasil dihapus.');
}
```

Route juga dapat disederhanakan dengan:

```php
Route::resource('homestay', HomestayController::class);
```

---

### Manfaat

- Controller lebih ringkas.
- Tidak perlu menulis `findOrFail()` berulang kali.
- Laravel otomatis mencari data berdasarkan parameter route.
- Kode lebih sesuai standar Laravel.

### Prioritas

Sedang

### Status

Belum dikerjakan

---

## 5.6 Refactoring AuthController: Redirect Berdasarkan Role

### Kondisi Saat Ini

Pada `AuthController`, redirect berdasarkan role sudah berjalan:

```php
if ($user->role === 'admin') {
    return redirect()->intended('/admin/dashboard')
        ->with('success', 'Selamat datang kembali, Admin ' . $user->nama . '!');
}

return redirect()->intended('/dashboard')
    ->with('success', 'Selamat datang kembali, ' . $user->nama . '!');
```

Namun, URL redirect masih ditulis manual menggunakan string `/admin/dashboard` dan `/dashboard`.

Selain itu, nama aplikasi pada pesan register masih menggunakan:

```php
Aura Stay & Style
```

Jika nama project sudah final sebagai Natasha Homestay & Harau Souvenir atau pentathree-app, maka pesan tersebut perlu disesuaikan agar konsisten.

---

### Target Refactoring

Gunakan route name:

```php
if ($user->role === 'admin') {
    return redirect()->intended(route('admin.dashboard'))
        ->with('success', 'Selamat datang kembali, Admin ' . $user->nama . '!');
}

return redirect()->intended(route('dashboard'))
    ->with('success', 'Selamat datang kembali, ' . $user->nama . '!');
```

Atau buat method khusus:

```php
private function redirectByRole($user)
{
    if ($user->role === 'admin') {
        return redirect()->intended(route('admin.dashboard'))
            ->with('success', 'Selamat datang kembali, Admin ' . $user->nama . '!');
    }

    return redirect()->intended(route('dashboard'))
        ->with('success', 'Selamat datang kembali, ' . $user->nama . '!');
}
```

Lalu di method `login()`:

```php
return $this->redirectByRole($user);
```

Pesan register juga dapat disesuaikan:

```php
return redirect('/dashboard')->with('success', 'Registrasi berhasil! Selamat datang di Natasha Homestay & Harau Souvenir.');
```

---

### Manfaat

- Redirect lebih aman karena menggunakan route name.
- Jika URL berubah, controller tidak perlu banyak diubah.
- Pesan aplikasi lebih konsisten dengan nama project.
- AuthController lebih rapi.

### Prioritas

Rendah

### Status

Sebagian sudah baik, perlu dirapikan

---

## 5.7 Refactoring Auth Validation yang Sudah Menggunakan FormRequest

### Kondisi Saat Ini

Pada `AuthController`, method `login()` sudah menggunakan:

```php
public function login(LoginRequest $request)
```

Method `register()` juga sudah menggunakan:

```php
public function register(RegisterRequest $request)
```

Ini berarti validasi login dan register sudah dipisahkan dari controller ke FormRequest.

---

### Dampak Positif

- AuthController lebih bersih.
- Rule validasi login dan register lebih mudah dikelola.
- Validasi dapat dipisahkan antara login dan register.
- Struktur kode lebih sesuai standar Laravel.

---

### Catatan Lanjutan

Pastikan file berikut sudah tersedia dan berisi rule validasi yang sesuai:

```text
app/Http/Requests/LoginRequest.php
app/Http/Requests/RegisterRequest.php
```

Jika ingin lebih rapi, file request auth dapat dikelompokkan menjadi:

```text
app/Http/Requests/Auth/LoginRequest.php
app/Http/Requests/Auth/RegisterRequest.php
```

Jika dipindahkan ke folder `Auth`, namespace perlu disesuaikan.

---

### Prioritas

Rendah

### Status

Sudah dikerjakan sebagian

---

## 5.8 Refactoring Query Homestay dengan Pagination dan Search

### Kondisi Saat Ini

Pada method `index()` di `HomestayController`, data diambil menggunakan:

```php
$homestays = Homestay::latest()->get();
```

Jika data homestay semakin banyak, penggunaan `get()` akan mengambil seluruh data sekaligus.

---

### Target Refactoring

Menggunakan pagination:

```php
public function index(Request $request)
{
    $homestays = Homestay::query()
        ->when($request->search, function ($query, $search) {
            $query->where('nama_homestay', 'like', '%' . $search . '%');
        })
        ->latest()
        ->paginate(10);

    return view('homestay.index', compact('homestays'));
}
```

---

### Manfaat

- Data tidak dimuat seluruhnya sekaligus.
- Halaman lebih ringan.
- Admin dapat mencari data homestay.
- Cocok jika data semakin banyak.

### Prioritas

Sedang

### Status

Belum dikerjakan

---

## 5.9 Refactoring Nama Role agar Konsisten

### Kondisi Saat Ini

Pada project, role yang digunakan adalah:

```php
role:admin
role:user
```

Pada beberapa sistem, role pelanggan biasanya menggunakan nama `customer`. Namun pada project ini masih menggunakan `user`.

Hal ini tidak salah, tetapi perlu dipastikan konsisten di semua bagian project.

---

### Pilihan Refactoring

Pilihan 1 — Tetap menggunakan `user`:

```php
role:admin
role:user
```

Pilihan 2 — Mengubah menjadi `customer` agar lebih spesifik:

```php
role:admin
role:customer
```

Jika menggunakan `customer`, maka bagian register perlu diubah:

```php
'role' => 'customer'
```

Dan route juga diubah:

```php
Route::middleware('role:customer')->group(function () {
    // route customer
});
```

---

### Rekomendasi

Untuk project homestay dan souvenir, role `customer` lebih jelas daripada `user`, karena admin juga sebenarnya termasuk user pada sistem.

Namun, jika database dan kode sudah banyak menggunakan `user`, boleh tetap menggunakan `user` agar tidak banyak perubahan.

Yang penting adalah konsisten.

---

### Prioritas

Rendah

### Status

Opsional

---

## 5.10 Refactoring CRUD Souvenir, Reservasi, Pembayaran, dan Laporan

### Kondisi Saat Ini

Controller lain sudah dipisahkan berdasarkan modul:

```text
Souvenir/SouvenirController.php
Reservasi/ReservasiController.php
Pembayaran/PembayaranController.php
Laporan/LaporanController.php
```

Namun perlu dipastikan setiap controller tidak menumpuk terlalu banyak logic.

---

### Target Refactoring

Jika controller mulai panjang, pisahkan logic menjadi service:

```text
app/Services/SouvenirService.php
app/Services/ReservasiService.php
app/Services/PembayaranService.php
app/Services/LaporanService.php
```

Contoh pembagian:

| Controller           | Service yang Disarankan | Fungsi                                                    |
| -------------------- | ----------------------- | --------------------------------------------------------- |
| SouvenirController   | SouvenirService         | Mengelola stok, upload gambar, dan katalog                |
| ReservasiController  | ReservasiService        | Mengelola booking, jadwal, dan status reservasi           |
| PembayaranController | PaymentService          | Mengelola status pembayaran dan integrasi payment gateway |
| LaporanController    | ReportService           | Mengelola filter laporan dan generate data laporan        |

---

### Manfaat

- Controller tidak terlalu berat.
- Logic bisnis lebih mudah diuji.
- Setiap fitur punya tanggung jawab yang jelas.
- Cocok untuk project tim karena pembagian kerja lebih rapi.

### Prioritas

Sedang

### Status

Belum dikerjakan

---

# 6. Riwayat Refactoring

| Tanggal | Area | Deskripsi                                             | Dilakukan oleh | Status |
| ------- | ---- | ----------------------------------------------------- | -------------- | ------ |
| —       | —    | Belum ada riwayat refactoring final pada project ini. | —              | —      |

> Setiap refactoring yang sudah selesai dikerjakan wajib dicatat pada tabel ini, termasuk tanggal pengerjaan, area kode yang diubah, deskripsi singkat perubahan, nama anggota yang mengerjakan, dan status pengerjaan.

## 7. Kesimpulan

Berdasarkan struktur controller, route, dan kode yang ada, project **pentathree-app** sudah memiliki pondasi yang cukup baik karena modul utama telah dipisahkan ke dalam folder controller masing-masing.
