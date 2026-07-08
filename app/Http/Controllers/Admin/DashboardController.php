<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Homestay;
use App\Models\Pembayaran;
use App\Models\Pemesanan;
use App\Models\Souvenir;
use App\Models\Ulasan;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalHomestay = Homestay::count();
        $homestayBaruBulanIni = Homestay::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $totalSouvenir = Souvenir::count();
        $souvenirTersedia = Souvenir::where('status', 'Tersedia')->count();

        $totalReservasi = Pemesanan::where('jenis_pemesanan', Pemesanan::JENIS_HOMESTAY)->count();
        $reservasiAktif = Pemesanan::where('jenis_pemesanan', Pemesanan::JENIS_HOMESTAY)
            ->whereNotIn('status_pemesanan', Pemesanan::inactiveHomestayStatuses())
            ->count();

        $totalPesananSouvenir = Pemesanan::where('jenis_pemesanan', Pemesanan::JENIS_SOUVENIR)->count();
        $pesananSouvenirAktif = Pemesanan::where('jenis_pemesanan', Pemesanan::JENIS_SOUVENIR)
            ->whereNotIn('status_pemesanan', [Pemesanan::STATUS_DIBATALKAN, Pemesanan::STATUS_KEDALUWARSA])
            ->count();

        $pendapatanBulanIni = Pembayaran::where('status_pembayaran', Pembayaran::STATUS_TERVERIFIKASI)
            ->whereMonth('tanggal_pembayaran', now()->month)
            ->whereYear('tanggal_pembayaran', now()->year)
            ->sum('jumlah_bayar');

        $pendapatanBulanLalu = Pembayaran::where('status_pembayaran', Pembayaran::STATUS_TERVERIFIKASI)
            ->whereMonth('tanggal_pembayaran', now()->subMonth()->month)
            ->whereYear('tanggal_pembayaran', now()->subMonth()->year)
            ->sum('jumlah_bayar');

        $pendapatanHariIni = Pembayaran::where('status_pembayaran', Pembayaran::STATUS_TERVERIFIKASI)
            ->whereDate('tanggal_pembayaran', now()->today())
            ->sum('jumlah_bayar');

        $pendapatanTotal = Pembayaran::where('status_pembayaran', Pembayaran::STATUS_TERVERIFIKASI)
            ->sum('jumlah_bayar');

        $pembayaranMenunggu = Pembayaran::where('status_pembayaran', Pembayaran::STATUS_MENUNGGU_VERIFIKASI)->count();
        $pembayaranDitolak = Pembayaran::where('status_pembayaran', Pembayaran::STATUS_DITOLAK)->count();
        $pembayaranTerverifikasi = Pembayaran::where('status_pembayaran', Pembayaran::STATUS_TERVERIFIKASI)->count();
        $totalPembayaran = Pembayaran::count();

        $pembayaranHariIni = Pembayaran::whereDate('tanggal_pembayaran', now()->today())->count();

        $totalUser = User::count();
        $userBaruBulanIni = User::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        $userAdmin = User::where('role', 'admin')->count();
        $userPelanggan = User::where('role', 'user')->count();

        $totalUlasan = Ulasan::count();
        $ulasanBulanIni = Ulasan::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $avgRating = Ulasan::avg('rating') ?? 0;
        $ratingHomestay = Ulasan::whereNotNull('homestay_id')->avg('rating') ?? 0;
        $ratingSouvenir = Ulasan::whereNotNull('souvenir_id')->avg('rating') ?? 0;

        $homestayTersedia = Homestay::where('status', 'Tersedia')->count();
        $homestayTidakTersedia = Homestay::where('status', '!=', 'Tersedia')->count();

        $souvenirHabis = Souvenir::where('stok', 0)->count();
        $souvenirStokMenipis = Souvenir::where('stok', '<=', 5)->where('stok', '>', 0)->count();

        $recentUsers = User::latest()->take(5)->get();
        $topUsers = User::select('users.*')
    ->selectSub(function ($q) {
        $q->from('pemesanans')
            ->whereColumn('pemesanans.user_id', 'users.user_id')
            ->select(DB::raw('COALESCE(SUM(total_harga), 0)'));
    }, 'total_belanja')
    ->orderByDesc('total_belanja')
    ->take(5)
    ->get();

        $recentOrders = Pemesanan::with('user')
            ->latest('tanggal_pemesanan')
            ->take(5)
            ->get();

        $recentPayments = Pembayaran::with('pemesanan.user')
            ->where('status_pembayaran', Pembayaran::STATUS_MENUNGGU_VERIFIKASI)
            ->latest('tanggal_pembayaran')
            ->take(5)
            ->get();

        $recentVerifiedPayments = Pembayaran::with('pemesanan.user', 'verifier')
            ->where('status_pembayaran', Pembayaran::STATUS_TERVERIFIKASI)
            ->latest('tanggal_pembayaran')
            ->take(5)
            ->get();

        $orderStats = Pemesanan::select('status_pemesanan', DB::raw('count(*) as total'))
            ->where('jenis_pemesanan', Pemesanan::JENIS_HOMESTAY)
            ->groupBy('status_pemesanan')
            ->pluck('total', 'status_pemesanan');

        $souvenirOrderStats = Pemesanan::select('status_pemesanan', DB::raw('count(*) as total'))
            ->where('jenis_pemesanan', Pemesanan::JENIS_SOUVENIR)
            ->groupBy('status_pemesanan')
            ->pluck('total', 'status_pemesanan');

        $topSouvenirs = Souvenir::orderByDesc('jumlah_terjual')->take(5)->get();

        $popularHomestays = Homestay::withCount(['detailPemesanans as total_booking' => function ($q) {
            $q->whereHas('pemesanan', fn ($q2) => $q2->whereNotIn('status_pemesanan', Pemesanan::inactiveHomestayStatuses()));
        }])->orderByDesc('total_booking')->take(5)->get();

        $upcomingCheckins = Pemesanan::where('jenis_pemesanan', Pemesanan::JENIS_HOMESTAY)
            ->where('status_pemesanan', Pemesanan::STATUS_DIKONFIRMASI)
            ->whereHas('detailPemesanans', fn ($q) => $q->where('check_in', '>=', now()->startOfDay()))
            ->with(['user', 'detailPemesanans' => fn ($q) => $q->whereNotNull('homestay_id')->with('homestay')])
            ->oldest()
            ->take(5)
            ->get();

        $ulasanTerbaru = Ulasan::with('user', 'pemesanan')
            ->latest()
            ->take(5)
            ->get();

        $ulasanRatingDistribution = Ulasan::select('rating', DB::raw('count(*) as total'))
            ->groupBy('rating')
            ->orderByDesc('rating')
            ->pluck('total', 'rating');

        $topHomestayByRating = Homestay::withAvg('ulasans', 'rating')
            ->whereHas('ulasans')
            ->orderByDesc('ulasans_avg_rating')
            ->take(5)
            ->get();

        $revenueTrend = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $revenue = Pembayaran::where('status_pembayaran', Pembayaran::STATUS_TERVERIFIKASI)
                ->whereMonth('tanggal_pembayaran', $month->month)
                ->whereYear('tanggal_pembayaran', $month->year)
                ->sum('jumlah_bayar');
            $revenueTrend[] = [
                'bulan' => $month->isoFormat('MMMM'),
                'total' => (int) $revenue,
            ];
        }

        $revenueTrendHomestay = [];
        $revenueTrendSouvenir = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $start = $month->copy()->startOfMonth();
            $end = $month->copy()->endOfMonth();

            $h = Pembayaran::where('status_pembayaran', Pembayaran::STATUS_TERVERIFIKASI)
                ->whereBetween('tanggal_pembayaran', [$start, $end])
                ->whereHas('pemesanan', fn ($q) => $q->where('jenis_pemesanan', Pemesanan::JENIS_HOMESTAY))
                ->sum('jumlah_bayar');

            $s = Pembayaran::where('status_pembayaran', Pembayaran::STATUS_TERVERIFIKASI)
                ->whereBetween('tanggal_pembayaran', [$start, $end])
                ->whereHas('pemesanan', fn ($q) => $q->where('jenis_pemesanan', Pemesanan::JENIS_SOUVENIR))
                ->sum('jumlah_bayar');

            $revenueTrendHomestay[] = ['bulan' => $month->isoFormat('MMMM'), 'total' => (int) $h];
            $revenueTrendSouvenir[] = ['bulan' => $month->isoFormat('MMMM'), 'total' => (int) $s];
        }

        $pemesananHariIni = Pemesanan::whereDate('tanggal_pemesanan', now()->today())->count();
        $ulasanHariIni = Ulasan::whereDate('created_at', now()->today())->count();
        $userBaruHariIni = User::whereDate('created_at', now()->today())->count();

        $souvenirTerjualBulanIni = Pemesanan::where('jenis_pemesanan', Pemesanan::JENIS_SOUVENIR)
            ->whereNotIn('status_pemesanan', [Pemesanan::STATUS_DIBATALKAN, Pemesanan::STATUS_KEDALUWARSA])
            ->whereMonth('tanggal_pemesanan', now()->month)
            ->whereYear('tanggal_pemesanan', now()->year)
            ->count();

        return view('admin.dashboard', compact(
            'totalHomestay',
            'homestayBaruBulanIni',
            'totalSouvenir',
            'souvenirTersedia',
            'totalReservasi',
            'reservasiAktif',
            'totalPesananSouvenir',
            'pesananSouvenirAktif',
            'pendapatanBulanIni',
            'pendapatanBulanLalu',
            'pendapatanHariIni',
            'pendapatanTotal',
            'pembayaranMenunggu',
            'pembayaranDitolak',
            'pembayaranTerverifikasi',
            'totalPembayaran',
            'pembayaranHariIni',
            'totalUser',
            'userBaruBulanIni',
            'userAdmin',
            'userPelanggan',
            'recentUsers',
            'topUsers',
            'recentOrders',
            'recentPayments',
            'recentVerifiedPayments',
            'orderStats',
            'souvenirOrderStats',
            'topSouvenirs',
            'popularHomestays',
            'revenueTrend',
            'revenueTrendHomestay',
            'revenueTrendSouvenir',
            'avgRating',
            'upcomingCheckins',
            'totalUlasan',
            'ulasanBulanIni',
            'ratingHomestay',
            'ratingSouvenir',
            'ulasanTerbaru',
            'ulasanRatingDistribution',
            'topHomestayByRating',
            'homestayTersedia',
            'homestayTidakTersedia',
            'souvenirHabis',
            'souvenirStokMenipis',
            'pemesananHariIni',
            'ulasanHariIni',
            'userBaruHariIni',
            'souvenirTerjualBulanIni',
        ))->with([
            'homestayStatusLabels' => Pemesanan::homestayStatusLabels(),
            'souvenirStatusLabels' => Pemesanan::souvenirStatusLabels(),
            'statusLabels' => Pemesanan::statusLabels(),
        ]);
    }
}