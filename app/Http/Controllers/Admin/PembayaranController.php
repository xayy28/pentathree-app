<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Models\Pemesanan;
use App\Services\PaymentSettlementService;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    /**
     * Tampilkan daftar pembayaran untuk admin.
     */
    public function index(Request $request)
    {
        $status = $request->query('status');
        $statuses = [
            Pembayaran::STATUS_MENUNGGU_PEMBAYARAN,
            Pembayaran::STATUS_MENUNGGU_VERIFIKASI,
            Pembayaran::STATUS_TERVERIFIKASI,
            Pembayaran::STATUS_DITOLAK,
        ];

        $pembayarans = Pembayaran::with('pemesanan.user')
            ->whereHas('pemesanan', fn ($query) => $query->where('jenis_pemesanan', Pemesanan::JENIS_SOUVENIR))
            ->when(in_array($status, $statuses, true), fn ($query) => $query->where('status_pembayaran', $status))
            ->latest()
            ->get();

        return view('admin.pembayaran.index', compact('pembayarans', 'status', 'statuses'));
    }

    /**
     * Tampilkan detail pembayaran untuk admin.
     */
    public function show($pembayaran_id)
    {
        $pembayaran = $this->findSouvenirPaymentOrFail($pembayaran_id, [
            'pemesanan.user',
            'pemesanan.invoice',
            'pemesanan.detailPemesanans.souvenir',
            'verifier',
        ]);

        return view('admin.pembayaran.show', compact('pembayaran'));
    }

    /**
     * Verifikasi pembayaran dan proses efek transaksi.
     */
    public function verify($pembayaran_id, PaymentSettlementService $paymentSettlementService)
    {
        $pembayaran = $this->findSouvenirPaymentOrFail($pembayaran_id, [
            'pemesanan.detailPemesanans.souvenir',
        ]);

        if ($pembayaran->status_pembayaran === Pembayaran::STATUS_TERVERIFIKASI) {
            return redirect()->route('admin.pembayaran.show', $pembayaran->pembayaran_id)
                ->with('error', 'Pembayaran sudah diverifikasi sebelumnya.');
        }

        try {
            $verified = $paymentSettlementService->verify($pembayaran, auth()->user()->user_id);
        } catch (\RuntimeException $exception) {
            return redirect()->route('admin.pembayaran.show', $pembayaran->pembayaran_id)
                ->with('error', $exception->getMessage());
        }

        if (! $verified) {
            return redirect()->route('admin.pembayaran.show', $pembayaran->pembayaran_id)
                ->with('error', 'Pembayaran sudah diverifikasi sebelumnya.');
        }

        return redirect()->route('admin.pembayaran.show', $pembayaran->pembayaran_id)
            ->with('success', 'Pembayaran berhasil diverifikasi.');
    }

    /**
     * Tolak pembayaran pelanggan.
     */
    public function reject(Request $request, $pembayaran_id)
    {
        $validated = $request->validate([
            'catatan_admin' => 'nullable|string|max:1000',
        ]);

        $pembayaran = $this->findSouvenirPaymentOrFail($pembayaran_id, [
            'pemesanan',
        ]);

        if ($pembayaran->status_pembayaran === Pembayaran::STATUS_TERVERIFIKASI) {
            return redirect()->route('admin.pembayaran.show', $pembayaran->pembayaran_id)
                ->with('error', 'Pembayaran yang sudah diverifikasi tidak dapat ditolak.');
        }

        $pembayaran->update([
            'status_pembayaran' => Pembayaran::STATUS_DITOLAK,
            'catatan_admin' => $validated['catatan_admin'] ?? null,
            'verified_at' => null,
            'verified_by' => null,
        ]);

        $pembayaran->pemesanan->update([
            'status_pemesanan' => Pemesanan::STATUS_MENUNGGU_PEMBAYARAN,
        ]);

        return redirect()->route('admin.pembayaran.show', $pembayaran->pembayaran_id)
            ->with('success', 'Pembayaran berhasil ditolak.');
    }

    /**
     * Ubah status operasional pesanan souvenir setelah pembayaran valid.
     */
    public function updateStatus(Request $request, $pembayaran_id)
    {
        $allowedStatuses = [
            Pemesanan::STATUS_TERVERIFIKASI,
            Pemesanan::STATUS_DIPROSES,
            Pemesanan::STATUS_SIAP_DIAMBIL_DIKIRIM,
            Pemesanan::STATUS_SELESAI,
            Pemesanan::STATUS_DIBATALKAN,
            Pemesanan::STATUS_KEDALUWARSA,
        ];

        $validated = $request->validate([
            'status_pemesanan' => 'required|in:'.implode(',', $allowedStatuses),
        ]);

        $pembayaran = $this->findSouvenirPaymentOrFail($pembayaran_id, [
            'pemesanan',
        ]);

        if ($pembayaran->status_pembayaran !== Pembayaran::STATUS_TERVERIFIKASI) {
            return redirect()->route('admin.pembayaran.show', $pembayaran->pembayaran_id)
                ->with('error', 'Status pesanan hanya bisa diubah setelah pembayaran terverifikasi.');
        }

        $currentStatus = $pembayaran->pemesanan->status_pemesanan;
        $targetStatus = $validated['status_pemesanan'];

        if ($currentStatus === $targetStatus) {
            return redirect()->route('admin.pembayaran.show', $pembayaran->pembayaran_id)
                ->with('error', 'Pesanan sudah berada pada status tersebut.');
        }

        $nextStatuses = [
            Pemesanan::STATUS_TERVERIFIKASI => [
                Pemesanan::STATUS_DIPROSES,
                Pemesanan::STATUS_DIBATALKAN,
                Pemesanan::STATUS_KEDALUWARSA,
            ],
            Pemesanan::STATUS_DIPROSES => [
                Pemesanan::STATUS_SIAP_DIAMBIL_DIKIRIM,
                Pemesanan::STATUS_DIBATALKAN,
                Pemesanan::STATUS_KEDALUWARSA,
            ],
            Pemesanan::STATUS_SIAP_DIAMBIL_DIKIRIM => [
                Pemesanan::STATUS_SELESAI,
                Pemesanan::STATUS_DIBATALKAN,
                Pemesanan::STATUS_KEDALUWARSA,
            ],
        ];

        if (! in_array($targetStatus, $nextStatuses[$currentStatus] ?? [], true)) {
            return redirect()->route('admin.pembayaran.show', $pembayaran->pembayaran_id)
                ->with('error', 'Status pesanan tidak sesuai urutan alur souvenir.');
        }

        $pembayaran->pemesanan->update([
            'status_pemesanan' => $targetStatus,
        ]);

        $statusLabels = Pemesanan::souvenirStatusLabels();
        $statusLabel = $statusLabels[$targetStatus] ?? str_replace('_', ' ', $targetStatus);

        return redirect()->route('admin.pembayaran.show', $pembayaran->pembayaran_id)
            ->with('success', 'Status pesanan souvenir berhasil diubah menjadi '.$statusLabel.'.');
    }

    /**
     * Tandai pesanan souvenir selesai untuk status operasional admin.
     */
    public function complete($pembayaran_id)
    {
        $pembayaran = $this->findSouvenirPaymentOrFail($pembayaran_id, [
            'pemesanan',
        ]);

        if ($pembayaran->status_pembayaran !== Pembayaran::STATUS_TERVERIFIKASI) {
            return redirect()->route('admin.pembayaran.show', $pembayaran->pembayaran_id)
                ->with('error', 'Pesanan hanya bisa diselesaikan setelah pembayaran terverifikasi.');
        }

        if ($pembayaran->pemesanan->status_pemesanan === Pemesanan::STATUS_SELESAI) {
            return redirect()->route('admin.pembayaran.show', $pembayaran->pembayaran_id)
                ->with('error', 'Pesanan sudah selesai.');
        }

        if ($pembayaran->pemesanan->status_pemesanan !== Pemesanan::STATUS_SIAP_DIAMBIL_DIKIRIM) {
            return redirect()->route('admin.pembayaran.show', $pembayaran->pembayaran_id)
                ->with('error', 'Pesanan hanya bisa diselesaikan setelah status siap diambil atau dikirim.');
        }

        $pembayaran->pemesanan->update([
            'status_pemesanan' => Pemesanan::STATUS_SELESAI,
        ]);

        return redirect()->route('admin.pembayaran.show', $pembayaran->pembayaran_id)
            ->with('success', 'Pesanan souvenir berhasil ditandai selesai.');
    }

    private function findSouvenirPaymentOrFail($pembayaran_id, array $relations = []): Pembayaran
    {
        return Pembayaran::with($relations)
            ->whereHas('pemesanan', fn ($query) => $query->where('jenis_pemesanan', Pemesanan::JENIS_SOUVENIR))
            ->findOrFail($pembayaran_id);
    }
}
