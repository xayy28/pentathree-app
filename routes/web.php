<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\FasilitasController as AdminFasilitasController;
use App\Http\Controllers\Admin\HomestayController as AdminHomestayController;
use App\Http\Controllers\Admin\KategoriHomestayController as AdminKategoriHomestayController;
use App\Http\Controllers\Admin\LaporanController as AdminLaporanController;
use App\Http\Controllers\Admin\NotifikasiTransaksiController as AdminNotifikasiTransaksiController;
use App\Http\Controllers\Admin\PembayaranController as AdminPembayaranController;
use App\Http\Controllers\Admin\ReservasiController as AdminReservasiController;
use App\Http\Controllers\Admin\SouvenirController as AdminSouvenirController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\MidtransWebhookController;
use App\Http\Controllers\Pelanggan\HomestayBookingController as PelangganHomestayBookingController;
use App\Http\Controllers\Pelanggan\HomestayController as PelangganHomestayController;
use App\Http\Controllers\Pelanggan\KeranjangController as PelangganKeranjangController;
use App\Http\Controllers\Pelanggan\MidtransPaymentController as PelangganMidtransPaymentController;
use App\Http\Controllers\Pelanggan\PembayaranController as PelangganPembayaranController;
use App\Http\Controllers\Pelanggan\PemesananController as PelangganPemesananController;
use App\Http\Controllers\Pelanggan\ReservasiController as PelangganReservasiController;
use App\Http\Controllers\Pelanggan\SouvenirController as PelangganSouvenirController;
use App\Http\Controllers\Pelanggan\UlasanController as PelangganUlasanController;
use App\Http\Controllers\ProfileController;
use App\Models\Homestay;
use App\Models\Pemesanan;
use App\Models\Souvenir;
use App\Models\Ulasan;
use App\Models\User;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;

Route::post('/midtrans/notification', [MidtransWebhookController::class, 'handle'])
    ->withoutMiddleware([VerifyCsrfToken::class])
    ->name('midtrans.notification');

// Redirect Halaman Utama berdasarkan status login
Route::get('/', function () {
    if (auth()->check()) {
        return auth()->user()->role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('dashboard');
    }

    $homestays = Homestay::with('kategori')
        ->withAvg('ulasans', 'rating')
        ->withCount('ulasans')
        ->where('status', 'Tersedia')
        ->latest()
        ->limit(3)
        ->get();

    $souvenirs = Souvenir::withAvg('ulasans', 'rating')
        ->withCount('ulasans')
        ->where('status', 'Tersedia')
        ->where('stok', '>', 0)
        ->orderByDesc('jumlah_terjual')
        ->limit(4)
        ->get();

    $statTotalHomestay = Homestay::where('status', 'Tersedia')->count();
    $statTotalSouvenir = Souvenir::where('status', 'Tersedia')->count();
    $statTotalUser = User::where('role', 'user')->count();
    $statAvgRating = Ulasan::avg('rating');
    $statTotalUlasan = Ulasan::count();

    $ulasanTerbaru = Ulasan::with('user')
        ->whereNotNull('komentar')
        ->where('komentar', '!=', '')
        ->where('rating', '>=', 4)
        ->latest()
        ->limit(3)
        ->get();

    return view('welcome', compact(
        'homestays',
        'souvenirs',
        'statTotalHomestay',
        'statTotalSouvenir',
        'statTotalUser',
        'statAvgRating',
        'statTotalUlasan',
        'ulasanTerbaru',
    ));
})->name('home');

// Route untuk Guest (Belum Login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    // Password Reset Routes
    Route::get('/forgot-password', [\App\Http\Controllers\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [\App\Http\Controllers\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [\App\Http\Controllers\ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [\App\Http\Controllers\ResetPasswordController::class, 'reset'])->name('password.update');
});

// Route untuk Auth (Sudah Login)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Email Verification Routes
    Route::get('/email/verify', [\App\Http\Controllers\EmailVerificationController::class, 'notice'])->name('verification.notice');
    Route::post('/email/verification-notification', [\App\Http\Controllers\EmailVerificationController::class, 'resend'])->name('verification.send')->middleware('throttle:6,1');
    Route::get('/email/verify/{id}/{hash}', [\App\Http\Controllers\EmailVerificationController::class, 'verify'])->name('verification.verify')->middleware('signed');

    // Halaman khusus Admin
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('/admin/notifikasi/transaksi/{pemesanan_id}', [AdminNotifikasiTransaksiController::class, 'show'])->name('admin.notifikasi.transaksi');

        // Scaffolding Rute Modul PBL Admin
        Route::get('/admin/homestay', [AdminHomestayController::class, 'index'])->name('admin.homestay');
        Route::get('/admin/homestay/create', [AdminHomestayController::class, 'create'])->name('admin.homestay.create');
        Route::post('/admin/homestay', [AdminHomestayController::class, 'store'])->name('admin.homestay.store');
        Route::get('/admin/homestay/{homestay_id}/edit', [AdminHomestayController::class, 'edit'])->name('admin.homestay.edit');
        Route::put('/admin/homestay/{homestay_id}', [AdminHomestayController::class, 'update'])->name('admin.homestay.update');
        Route::delete('/admin/homestay/{homestay_id}', [AdminHomestayController::class, 'destroy'])->name('admin.homestay.destroy');

        // Rute Kategori Homestay
        // Rute Fasilitas
        Route::get('/admin/fasilitas', [AdminFasilitasController::class, 'index'])->name('admin.fasilitas');
        Route::get('/admin/fasilitas/create', [AdminFasilitasController::class, 'create'])->name('admin.fasilitas.create');
        Route::post('/admin/fasilitas', [AdminFasilitasController::class, 'store'])->name('admin.fasilitas.store');
        Route::get('/admin/fasilitas/{fasilitas_id}/edit', [AdminFasilitasController::class, 'edit'])->name('admin.fasilitas.edit');
        Route::put('/admin/fasilitas/{fasilitas_id}', [AdminFasilitasController::class, 'update'])->name('admin.fasilitas.update');
        Route::delete('/admin/fasilitas/{fasilitas_id}', [AdminFasilitasController::class, 'destroy'])->name('admin.fasilitas.destroy');

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
        Route::post('/admin/reservasi/{pemesanan_id}/verify-payment', [AdminReservasiController::class, 'verifyPayment'])->name('admin.reservasi.verify-payment');
        Route::post('/admin/reservasi/{pemesanan_id}/reject-payment', [AdminReservasiController::class, 'rejectPayment'])->name('admin.reservasi.reject-payment');
        Route::get('/admin/pembayaran', [AdminPembayaranController::class, 'index'])->name('admin.pembayaran');
        Route::get('/admin/pembayaran/{pembayaran_id}', [AdminPembayaranController::class, 'show'])->name('admin.pembayaran.show');
        Route::post('/admin/pembayaran/{pembayaran_id}/verify', [AdminPembayaranController::class, 'verify'])->name('admin.pembayaran.verify');
        Route::post('/admin/pembayaran/{pembayaran_id}/reject', [AdminPembayaranController::class, 'reject'])->name('admin.pembayaran.reject');
        Route::post('/admin/pembayaran/{pembayaran_id}/status', [AdminPembayaranController::class, 'updateStatus'])->name('admin.pembayaran.status');
        Route::post('/admin/pembayaran/{pembayaran_id}/complete', [AdminPembayaranController::class, 'complete'])->name('admin.pembayaran.complete');
        Route::get('/admin/user', [AdminUserController::class, 'index'])->name('admin.user');
        Route::get('/admin/laporan', [AdminLaporanController::class, 'index'])->name('admin.laporan');
        Route::get('/admin/laporan/pdf', [AdminLaporanController::class, 'downloadPdf'])->name('admin.laporan.pdf');
        Route::get('/admin/invoices/{invoice_id}', [InvoiceController::class, 'showForAdmin'])->name('admin.invoices.show');
        Route::get('/admin/invoices/{invoice_id}/pdf', [InvoiceController::class, 'downloadPdfForAdmin'])->name('admin.invoices.pdf');
    });

    // Halaman khusus User
    Route::middleware('role:user')->group(function () {
        Route::get('/dashboard', function () {
            $homestays = Homestay::with('kategori')
                ->withAvg('ulasans', 'rating')
                ->withCount('ulasans')
                ->where('status', 'Tersedia')
                ->latest()
                ->limit(4)
                ->get();

            $souvenirs = Souvenir::withAvg('ulasans', 'rating')
                ->withCount('ulasans')
                ->where('status', 'Tersedia')
                ->where('stok', '>', 0)
                ->orderByDesc('jumlah_terjual')
                ->limit(4)
                ->get();

            $totalHomestay = Homestay::where('status', 'Tersedia')->count();
            $totalSouvenir = Souvenir::where('status', 'Tersedia')->count();

            $pesananAktif = Pemesanan::where('user_id', auth()->user()->user_id)
                ->whereNotIn('status_pemesanan', [
                    Pemesanan::STATUS_SELESAI,
                    Pemesanan::STATUS_DIBATALKAN,
                    Pemesanan::STATUS_KEDALUWARSA,
                ])
                ->count();

            $pesananTerakhir = Pemesanan::where('user_id', auth()->user()->user_id)
                ->with('detailPemesanans')
                ->latest()
                ->limit(3)
                ->get();

            $totalUlasan = Ulasan::count();
            $avgRating = Ulasan::avg('rating');

            return view('pelanggan.dashboard', compact(
                'homestays',
                'souvenirs',
                'totalHomestay',
                'totalSouvenir',
                'pesananAktif',
                'pesananTerakhir',
                'totalUlasan',
                'avgRating',
            ));
        })->name('dashboard');

        Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
        Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::get('/profile/password/edit', [ProfileController::class, 'editPassword'])->name('profile.password.edit');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');

        Route::get('/homestay', [PelangganHomestayController::class, 'index'])->name('user.homestay');
        Route::get('/homestay/{homestay_id}', [PelangganHomestayController::class, 'show'])->name('user.homestay.show');
        Route::get('/souvenir', [PelangganSouvenirController::class, 'index'])->name('user.souvenir');
        Route::get('/souvenir/{souvenir_id}', [PelangganSouvenirController::class, 'show'])->name('user.souvenir.show');
        Route::get('/reservasi', [PelangganReservasiController::class, 'index'])->name('user.reservasi');
        Route::get('/pesanan', [PelangganPemesananController::class, 'index'])->name('user.pesanan.index');
        Route::get('/pesanan/{pemesanan_id}', [PelangganPemesananController::class, 'show'])->name('user.pesanan.show');
        Route::post('/pesanan/{pemesanan_id}/detail/{detail_pemesanan_id}/ulasan', [PelangganUlasanController::class, 'store'])->name('user.ulasan.store');
        Route::get('/pesanan/{pemesanan_id}/invoice', [InvoiceController::class, 'showForUser'])->name('user.invoices.show');
        Route::get('/pesanan/{pemesanan_id}/invoice/pdf', [InvoiceController::class, 'downloadPdfForUser'])->name('user.invoices.pdf');

        // Rute yang memerlukan verifikasi email
        Route::middleware('verified.email')->group(function () {
            Route::get('/homestay/{homestay_id}/booking', [PelangganHomestayBookingController::class, 'create'])->name('user.homestay.booking.create');
            Route::post('/homestay/{homestay_id}/booking', [PelangganHomestayBookingController::class, 'store'])->name('user.homestay.booking.store');
            Route::get('/reservasi/{homestay_id}', [PelangganReservasiController::class, 'create'])->name('user.reservasi.create');
            Route::get('/pesanan/{pemesanan_id}/pembayaran', [PelangganPembayaranController::class, 'create'])->name('user.pembayaran.create');
            Route::post('/pesanan/{pemesanan_id}/pembayaran', [PelangganPembayaranController::class, 'store'])->name('user.pembayaran.store');
            Route::post('/pesanan/{pemesanan_id}/midtrans-token', [PelangganMidtransPaymentController::class, 'token'])->name('user.pembayaran.midtrans.token');
            Route::post('/pesanan/{pemesanan_id}/midtrans-status', [PelangganMidtransPaymentController::class, 'status'])->name('user.pembayaran.midtrans.status');

            // Rute Keranjang Belanja User
            Route::get('/cart', [PelangganKeranjangController::class, 'index'])->name('cart.index');
            Route::get('/cart/checkout', [PelangganKeranjangController::class, 'checkout'])->name('checkout.index');
            Route::post('/cart/checkout', [PelangganKeranjangController::class, 'storeCheckout'])->name('checkout.store');
            Route::post('/cart/add', [PelangganKeranjangController::class, 'addToCart'])->name('cart.add');
            Route::put('/cart/update', [PelangganKeranjangController::class, 'updateQuantity'])->name('cart.update');
            Route::delete('/cart/{id}', [PelangganKeranjangController::class, 'destroy'])->name('cart.destroy');
        });
    });
});