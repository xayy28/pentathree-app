<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\HomestayController as AdminHomestayController;
use App\Http\Controllers\Admin\SouvenirController as AdminSouvenirController;
use App\Http\Controllers\Admin\ReservasiController as AdminReservasiController;
use App\Http\Controllers\Admin\PembayaranController as AdminPembayaranController;
use App\Http\Controllers\Admin\LaporanController as AdminLaporanController;

use App\Http\Controllers\Pelanggan\HomestayController as PelangganHomestayController;
use App\Http\Controllers\Pelanggan\SouvenirController as PelangganSouvenirController;
use App\Http\Controllers\Pelanggan\ReservasiController as PelangganReservasiController;
use Illuminate\Support\Facades\Route;

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
            return view('admin.dashboard');
        })->name('admin.dashboard');

        // Scaffolding Rute Modul PBL Admin
        Route::get('/admin/homestay', [AdminHomestayController::class, 'index'])->name('admin.homestay');
        Route::get('/admin/homestay/create', [AdminHomestayController::class, 'create'])->name('admin.homestay.create');
        Route::post('/admin/homestay', [AdminHomestayController::class, 'store'])->name('admin.homestay.store');
        Route::get('/admin/homestay/{homestay_id}/edit', [AdminHomestayController::class, 'edit'])->name('admin.homestay.edit');
        Route::put('/admin/homestay/{homestay_id}', [AdminHomestayController::class, 'update'])->name('admin.homestay.update');
        Route::delete('/admin/homestay/{homestay_id}', [AdminHomestayController::class, 'destroy'])->name('admin.homestay.destroy');
        Route::get('/admin/souvenir', [AdminSouvenirController::class, 'index'])->name('admin.souvenir');
        Route::get('/admin/souvenir/create', [AdminSouvenirController::class, 'create'])->name('admin.souvenir.create');
        Route::post('/admin/souvenir', [AdminSouvenirController::class, 'store'])->name('admin.souvenir.store');
        Route::get('/admin/souvenir/{souvenir_id}/edit', [AdminSouvenirController::class, 'edit'])->name('admin.souvenir.edit');
        Route::put('/admin/souvenir/{souvenir_id}', [AdminSouvenirController::class, 'update'])->name('admin.souvenir.update');
        Route::delete('/admin/souvenir/{souvenir_id}', [AdminSouvenirController::class, 'destroy'])->name('admin.souvenir.destroy');
        Route::get('/admin/reservasi', [AdminReservasiController::class, 'index'])->name('admin.reservasi');
        Route::get('/admin/pembayaran', [AdminPembayaranController::class, 'index'])->name('admin.pembayaran');
        Route::get('/admin/laporan', [AdminLaporanController::class, 'index'])->name('admin.laporan');
    });

    // Halaman khusus User
    Route::middleware('role:user')->group(function () {
        Route::get('/dashboard', function () {
            return view('pelanggan.dashboard');
        })->name('dashboard');

        // Rute Modul PBL untuk User
        Route::get('/homestay', [PelangganHomestayController::class, 'index'])->name('user.homestay');
        Route::get('/souvenir', [PelangganSouvenirController::class, 'index'])->name('user.souvenir');
        Route::get('/reservasi', [PelangganReservasiController::class, 'index'])->name('user.reservasi');
    });
});
