<?php

use App\Http\Controllers\Admin\HomestayController as AdminHomestayController;
use App\Http\Controllers\Admin\KategoriHomestayController as AdminKategoriHomestayController;
use App\Http\Controllers\Admin\LaporanController as AdminLaporanController;
use App\Http\Controllers\Admin\PembayaranController as AdminPembayaranController;
use App\Http\Controllers\Admin\ReservasiController as AdminReservasiController;
use App\Http\Controllers\Admin\SouvenirController as AdminSouvenirController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Pelanggan\HomestayBookingController as PelangganHomestayBookingController;
use App\Http\Controllers\Pelanggan\HomestayController as PelangganHomestayController;
use App\Http\Controllers\Pelanggan\KeranjangController as PelangganKeranjangController;
use App\Http\Controllers\Pelanggan\PembayaranController as PelangganPembayaranController;
use App\Http\Controllers\Pelanggan\PemesananController as PelangganPemesananController;
use App\Http\Controllers\Pelanggan\ReservasiController as PelangganReservasiController;
use App\Http\Controllers\Pelanggan\SouvenirController as PelangganSouvenirController;
use App\Http\Controllers\ProfileController;
use App\Models\Homestay;
use App\Models\Pembayaran;
use App\Models\Pemesanan;
use App\Models\Souvenir;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

// Redirect Halaman Utama berdasarkan status login
Route::get('/', function () {
    if (auth()->check()) {
        return auth()->user()->role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('dashboard');
    }

    return redirect()->route('login');
});

// Route untuk Guest (Belum Login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Route untuk Auth (Sudah Login)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Halaman khusus Admin
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/dashboard', function () {
            $totalHomestay = Homestay::count();
            $homestayBaruBulanIni = Homestay::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count();
            $totalSouvenir = Souvenir::count();
            $souvenirTersedia = Souvenir::where('status', 'Tersedia')->count();
            $totalReservasi = Schema::hasTable('pemesanans')
                ? DB::table('pemesanans')->where('jenis_pemesanan', 'homestay')->count()
                : 0;
            $reservasiAktif = Schema::hasTable('pemesanans')
                ? DB::table('pemesanans')
                    ->where('jenis_pemesanan', Pemesanan::JENIS_HOMESTAY)
                    ->whereNotIn('status_pemesanan', [
                        Pemesanan::STATUS_DIBATALKAN,
                        Pemesanan::STATUS_SELESAI,
                    ])
                    ->count()
                : 0;
            $pendapatanBulanIni = Schema::hasTable('pembayarans')
                ? Pembayaran::where('status_pembayaran', Pembayaran::STATUS_TERVERIFIKASI)
                    ->whereMonth('tanggal_pembayaran', now()->month)
                    ->whereYear('tanggal_pembayaran', now()->year)
                    ->sum('jumlah_bayar')
                : 0;
            $pembayaranMenunggu = Schema::hasTable('pembayarans')
                ? Pembayaran::where('status_pembayaran', Pembayaran::STATUS_MENUNGGU_VERIFIKASI)->count()
                : 0;
            $totalUser = User::count();
            $userBaruBulanIni = User::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count();
            $recentUsers = User::latest()->take(3)->get();

            return view('admin.dashboard', compact(
                'totalHomestay',
                'homestayBaruBulanIni',
                'totalSouvenir',
                'souvenirTersedia',
                'totalReservasi',
                'reservasiAktif',
                'pendapatanBulanIni',
                'pembayaranMenunggu',
                'totalUser',
                'userBaruBulanIni',
                'recentUsers',
            ));
        })->name('admin.dashboard');

        // Scaffolding Rute Modul PBL Admin
        Route::get('/admin/homestay', [AdminHomestayController::class, 'index'])->name('admin.homestay');
        Route::get('/admin/homestay/create', [AdminHomestayController::class, 'create'])->name('admin.homestay.create');
        Route::post('/admin/homestay', [AdminHomestayController::class, 'store'])->name('admin.homestay.store');
        Route::get('/admin/homestay/{homestay_id}/edit', [AdminHomestayController::class, 'edit'])->name('admin.homestay.edit');
        Route::put('/admin/homestay/{homestay_id}', [AdminHomestayController::class, 'update'])->name('admin.homestay.update');
        Route::delete('/admin/homestay/{homestay_id}', [AdminHomestayController::class, 'destroy'])->name('admin.homestay.destroy');

        // Rute Kategori Homestay
        Route::get('/admin/kategori-homestay', [AdminKategoriHomestayController::class, 'index'])->name('admin.kategori-homestay');
        Route::get('/admin/kategori-homestay/create', [AdminKategoriHomestayController::class, 'create'])->name('admin.kategori-homestay.create');
        Route::post('/admin/kategori-homestay', [AdminKategoriHomestayController::class, 'store'])->name('admin.kategori-homestay.store');
        Route::get('/admin/kategori-homestay/{kategori_id}/edit', [AdminKategoriHomestayController::class, 'edit'])->name('admin.kategori-homestay.edit');
        Route::put('/admin/kategori-homestay/{kategori_id}', [AdminKategoriHomestayController::class, 'update'])->name('admin.kategori-homestay.update');
        Route::delete('/admin/kategori-homestay/{kategori_id}', [AdminKategoriHomestayController::class, 'destroy'])->name('admin.kategori-homestay.destroy');
        Route::get('/admin/souvenir', [AdminSouvenirController::class, 'index'])->name('admin.souvenir');
        Route::get('/admin/souvenir/create', [AdminSouvenirController::class, 'create'])->name('admin.souvenir.create');
        Route::post('/admin/souvenir', [AdminSouvenirController::class, 'store'])->name('admin.souvenir.store');
        Route::get('/admin/souvenir/{souvenir_id}/edit', [AdminSouvenirController::class, 'edit'])->name('admin.souvenir.edit');
        Route::put('/admin/souvenir/{souvenir_id}', [AdminSouvenirController::class, 'update'])->name('admin.souvenir.update');
        Route::delete('/admin/souvenir/{souvenir_id}', [AdminSouvenirController::class, 'destroy'])->name('admin.souvenir.destroy');
        Route::get('/admin/reservasi', [AdminReservasiController::class, 'index'])->name('admin.reservasi');
        Route::get('/admin/reservasi/{pemesanan_id}', [AdminReservasiController::class, 'show'])->name('admin.reservasi.show');
        Route::post('/admin/reservasi/{pemesanan_id}/status', [AdminReservasiController::class, 'updateStatus'])->name('admin.reservasi.status');
        Route::get('/admin/pembayaran', [AdminPembayaranController::class, 'index'])->name('admin.pembayaran');
        Route::get('/admin/pembayaran/{pembayaran_id}', [AdminPembayaranController::class, 'show'])->name('admin.pembayaran.show');
        Route::post('/admin/pembayaran/{pembayaran_id}/verify', [AdminPembayaranController::class, 'verify'])->name('admin.pembayaran.verify');
        Route::post('/admin/pembayaran/{pembayaran_id}/reject', [AdminPembayaranController::class, 'reject'])->name('admin.pembayaran.reject');
        Route::get('/admin/laporan', [AdminLaporanController::class, 'index'])->name('admin.laporan');
        Route::get('/admin/laporan/pdf', [AdminLaporanController::class, 'downloadPdf'])->name('admin.laporan.pdf');
    });

    // Halaman khusus User
    Route::middleware('role:user')->group(function () {
        Route::get('/dashboard', function () {
            return view('pelanggan.dashboard');
        })->name('dashboard');

        Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
        Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::get('/profile/password/edit', [ProfileController::class, 'editPassword'])->name('profile.password.edit');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');

        // Rute Modul PBL untuk User
        Route::get('/homestay', [PelangganHomestayController::class, 'index'])->name('user.homestay');
        Route::get('/homestay/{homestay_id}/booking', [PelangganHomestayBookingController::class, 'create'])->name('user.homestay.booking.create');
        Route::post('/homestay/{homestay_id}/booking', [PelangganHomestayBookingController::class, 'store'])->name('user.homestay.booking.store');
        Route::get('/souvenir', [PelangganSouvenirController::class, 'index'])->name('user.souvenir');
        Route::get('/souvenir/{souvenir_id}', [PelangganSouvenirController::class, 'show'])->name('user.souvenir.show');
        Route::get('/reservasi', [PelangganReservasiController::class, 'index'])->name('user.reservasi');
        Route::get('/pesanan', [PelangganPemesananController::class, 'index'])->name('user.pesanan.index');
        Route::get('/pesanan/{pemesanan_id}', [PelangganPemesananController::class, 'show'])->name('user.pesanan.show');
        Route::get('/pesanan/{pemesanan_id}/pembayaran', [PelangganPembayaranController::class, 'create'])->name('user.pembayaran.create');
        Route::post('/pesanan/{pemesanan_id}/pembayaran', [PelangganPembayaranController::class, 'store'])->name('user.pembayaran.store');
        Route::get('/reservasi/{homestay_id}', [PelangganReservasiController::class, 'create'])->name('user.reservasi.create');

        // Rute Keranjang Belanja User
        Route::get('/cart', [PelangganKeranjangController::class, 'index'])->name('cart.index');
        Route::get('/cart/checkout', [PelangganKeranjangController::class, 'checkout'])->name('checkout.index');
        Route::post('/cart/checkout', [PelangganKeranjangController::class, 'storeCheckout'])->name('checkout.store');
        Route::post('/cart/add', [PelangganKeranjangController::class, 'addToCart'])->name('cart.add');
        Route::put('/cart/update', [PelangganKeranjangController::class, 'updateQuantity'])->name('cart.update');
        Route::delete('/cart/{id}', [PelangganKeranjangController::class, 'destroy'])->name('cart.destroy');
    });
});
