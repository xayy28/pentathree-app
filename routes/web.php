<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Homestay\HomestayController;
use App\Http\Controllers\Souvenir\SouvenirController;
use App\Http\Controllers\Reservasi\ReservasiController;
use App\Http\Controllers\Pembayaran\PembayaranController;
use App\Http\Controllers\Laporan\LaporanController;
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
        Route::get('/admin/homestay', [HomestayController::class, 'index'])->name('admin.homestay');
        Route::get('/admin/homestay/create', [HomestayController::class, 'create'])->name('admin.homestay.create');
        Route::post('/admin/homestay', [HomestayController::class, 'store'])->name('admin.homestay.store');
        Route::get('/admin/homestay/{homestay_id}/edit', [HomestayController::class, 'edit'])->name('admin.homestay.edit');
        Route::put('/admin/homestay/{homestay_id}', [HomestayController::class, 'update'])->name('admin.homestay.update');
        Route::delete('/admin/homestay/{homestay_id}', [HomestayController::class, 'destroy'])->name('admin.homestay.destroy');
        Route::get('/admin/souvenir', [SouvenirController::class, 'index'])->name('admin.souvenir');
        Route::get('/admin/souvenir/create', [SouvenirController::class, 'create'])->name('admin.souvenir.create');
        Route::post('/admin/souvenir', [SouvenirController::class, 'store'])->name('admin.souvenir.store');
        Route::get('/admin/souvenir/{souvenir_id}/edit', [SouvenirController::class, 'edit'])->name('admin.souvenir.edit');
        Route::put('/admin/souvenir/{souvenir_id}', [SouvenirController::class, 'update'])->name('admin.souvenir.update');
        Route::delete('/admin/souvenir/{souvenir_id}', [SouvenirController::class, 'destroy'])->name('admin.souvenir.destroy');
        Route::get('/admin/reservasi', [ReservasiController::class, 'index'])->name('admin.reservasi');
        Route::get('/admin/pembayaran', [PembayaranController::class, 'index'])->name('admin.pembayaran');
        Route::get('/admin/laporan', [LaporanController::class, 'index'])->name('admin.laporan');
    });

    // Halaman khusus User
    Route::middleware('role:user')->group(function () {
        Route::get('/dashboard', function () {
            return view('dashboard');
        })->name('dashboard');

        // Rute Modul PBL untuk User
        Route::get('/homestay', [HomestayController::class, 'index'])->name('user.homestay');
        Route::get('/souvenir', [SouvenirController::class, 'index'])->name('user.souvenir');
        Route::get('/reservasi', [ReservasiController::class, 'index'])->name('user.reservasi');
    });
});
