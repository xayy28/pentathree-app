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

    private function findSouvenirPaymentOrFail($pembayaran_id, array $relations = []): Pembayaran
    {
        return Pembayaran::with($relations)
            ->whereHas('pemesanan', fn ($query) => $query->where('jenis_pemesanan', Pemesanan::JENIS_SOUVENIR))
            ->findOrFail($pembayaran_id);
    }
}
