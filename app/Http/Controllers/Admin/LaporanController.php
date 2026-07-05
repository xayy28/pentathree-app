<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DetailPemesanan;
use App\Models\Pembayaran;
use App\Models\Pemesanan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    /**
     * Tampilkan laporan untuk admin.
     */
    public function index(Request $request)
    {
        return view('admin.laporan.index', $this->reportData($request));
    }

    /**
     * Unduh laporan admin dalam format PDF.
     */
    public function downloadPdf(Request $request)
    {
        $pdf = Pdf::loadView('admin.laporan.pdf', $this->reportData($request))
            ->setPaper('a4', 'portrait');

        return $pdf->download('laporan-natasha-'.now()->format('Ymd-His').'.pdf');
    }

    /**
     * Data laporan yang dipakai halaman web dan PDF.
     */
    private function reportData(Request $request): array
    {
        $validated = $request->validate([
            'date_from' => ['nullable', 'date'],
            'date_to' => ['nullable', 'date', 'after_or_equal:date_from'],
        ]);

        $dateFrom = filled($validated['date_from'] ?? null)
            ? Carbon::parse($validated['date_from'])->startOfDay()
            : null;
        $dateTo = filled($validated['date_to'] ?? null)
            ? Carbon::parse($validated['date_to'])->endOfDay()
            : null;

        $verifiedPayments = Pembayaran::query()
            ->with('pemesanan.user')
            ->where('status_pembayaran', Pembayaran::STATUS_TERVERIFIKASI)
            ->when($dateFrom, fn ($query) => $query->where('tanggal_pembayaran', '>=', $dateFrom))
            ->when($dateTo, fn ($query) => $query->where('tanggal_pembayaran', '<=', $dateTo));

        $pendingPayments = Pembayaran::query()
            ->where('status_pembayaran', Pembayaran::STATUS_MENUNGGU_VERIFIKASI)
            ->when($dateFrom, fn ($query) => $query->where('tanggal_pembayaran', '>=', $dateFrom))
            ->when($dateTo, fn ($query) => $query->where('tanggal_pembayaran', '<=', $dateTo));

        $reservationQuery = Pemesanan::query()
            ->where('jenis_pemesanan', Pemesanan::JENIS_HOMESTAY)
            ->when($dateFrom, fn ($query) => $query->where('tanggal_pemesanan', '>=', $dateFrom))
            ->when($dateTo, fn ($query) => $query->where('tanggal_pemesanan', '<=', $dateTo));

        $summary = [
            'total_pendapatan' => (clone $verifiedPayments)->sum('jumlah_bayar'),
            'pendapatan_souvenir' => (clone $verifiedPayments)
                ->whereHas('pemesanan', fn ($query) => $query->where('jenis_pemesanan', Pemesanan::JENIS_SOUVENIR))
                ->sum('jumlah_bayar'),
            'pendapatan_homestay' => (clone $verifiedPayments)
                ->whereHas('pemesanan', fn ($query) => $query->where('jenis_pemesanan', Pemesanan::JENIS_HOMESTAY))
                ->sum('jumlah_bayar'),
            'transaksi_terverifikasi' => (clone $verifiedPayments)->count(),
            'pembayaran_menunggu' => (clone $pendingPayments)->count(),
            'total_reservasi' => (clone $reservationQuery)->count(),
        ];

        $souvenirSales = DetailPemesanan::query()
            ->select([
                'souvenir_id',
                'nama_item',
                DB::raw('SUM(jumlah) as total_terjual'),
                DB::raw('SUM(subtotal) as total_penjualan'),
            ])
            ->whereNotNull('souvenir_id')
            ->whereHas('pemesanan.pembayaran', function ($query) use ($dateFrom, $dateTo) {
                $query->where('status_pembayaran', Pembayaran::STATUS_TERVERIFIKASI)
                    ->when($dateFrom, fn ($paymentQuery) => $paymentQuery->where('tanggal_pembayaran', '>=', $dateFrom))
                    ->when($dateTo, fn ($paymentQuery) => $paymentQuery->where('tanggal_pembayaran', '<=', $dateTo));
            })
            ->groupBy('souvenir_id', 'nama_item')
            ->orderByDesc('total_terjual')
            ->limit(5)
            ->get();

        $reservationStatuses = [
            Pemesanan::STATUS_MENUNGGU_PEMBAYARAN,
            Pemesanan::STATUS_MENUNGGU_VERIFIKASI,
            Pemesanan::STATUS_DIPROSES,
            Pemesanan::STATUS_DIKONFIRMASI,
            Pemesanan::STATUS_SELESAI,
            Pemesanan::STATUS_DIBATALKAN,
        ];

        $reservationStatusCounts = collect($reservationStatuses)
            ->mapWithKeys(fn ($status) => [
                $status => (clone $reservationQuery)->where('status_pemesanan', $status)->count(),
            ]);

        $recentPayments = (clone $verifiedPayments)
            ->latest('tanggal_pembayaran')
            ->limit(5)
            ->get();

        return compact(
            'dateFrom',
            'dateTo',
            'summary',
            'souvenirSales',
            'reservationStatusCounts',
            'recentPayments'
        );
    }
}
