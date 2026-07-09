<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Models\Pemesanan;
use App\Services\PaymentSettlementService;
use Illuminate\Http\Request;

class ReservasiController extends Controller
{
    /**
     * Tampilkan daftar reservasi untuk admin.
     */
    public function index(Request $request)
    {
        $status = $request->query('status');
        $statuses = Pemesanan::homestayStatuses();

        $reservasis = Pemesanan::with('user', 'detailPemesanans.homestay', 'pembayaran')
            ->where('jenis_pemesanan', Pemesanan::JENIS_HOMESTAY)
            ->when(in_array($status, $statuses, true), fn ($query) => $query->where('status_pemesanan', $status))
            ->latest('tanggal_pemesanan')
            ->get();

        return view('admin.reservasi.index', compact('reservasis', 'statuses', 'status'));
    }

    /**
     * Tampilkan detail reservasi untuk admin.
     */
    public function show($pemesanan_id)
    {
        $reservasi = Pemesanan::with('user', 'detailPemesanans.homestay', 'pembayaran', 'invoice')
            ->where('jenis_pemesanan', Pemesanan::JENIS_HOMESTAY)
            ->findOrFail($pemesanan_id);

        $reservasi->tandaiDilihatAdmin();

        return view('admin.reservasi.show', compact('reservasi'));
    }

    /**
     * Update status reservasi homestay.
     */
    public function updateStatus(Request $request, $pemesanan_id)
    {
        $validated = $request->validate([
            'status_pemesanan' => 'required|in:'.implode(',', Pemesanan::homestayStatuses()),
        ]);

        $reservasi = Pemesanan::with('pembayaran')
            ->where('jenis_pemesanan', Pemesanan::JENIS_HOMESTAY)
            ->findOrFail($pemesanan_id);

        if (
            in_array($validated['status_pemesanan'], [
                Pemesanan::STATUS_DIKONFIRMASI,
                Pemesanan::STATUS_SEDANG_MENGINAP,
                Pemesanan::STATUS_SELESAI,
            ], true)
            && $reservasi->pembayaran?->status_pembayaran !== Pembayaran::STATUS_TERVERIFIKASI
        ) {
            return redirect()->route('admin.reservasi.show', $reservasi->pemesanan_id)
                ->with('error', 'Reservasi hanya bisa dikonfirmasi, check-in, atau selesai setelah pembayaran terverifikasi.');
        }

        $reservasi->update([
            'status_pemesanan' => $validated['status_pemesanan'],
        ]);

        return redirect()->route('admin.reservasi.show', $reservasi->pemesanan_id)
            ->with('success', 'Status reservasi berhasil diperbarui.');
    }

    /**
     * Verifikasi pembayaran homestay dan konfirmasi booking.
     */
    public function verifyPayment($pemesanan_id, PaymentSettlementService $paymentSettlementService)
    {
        $reservasi = Pemesanan::with('pembayaran')
            ->where('jenis_pemesanan', Pemesanan::JENIS_HOMESTAY)
            ->findOrFail($pemesanan_id);

        if (! $reservasi->pembayaran) {
            return redirect()->route('admin.reservasi.show', $reservasi->pemesanan_id)
                ->with('error', 'Reservasi ini belum memiliki pembayaran.');
        }

        if ($reservasi->pembayaran->status_pembayaran !== Pembayaran::STATUS_MENUNGGU_VERIFIKASI) {
            return redirect()->route('admin.reservasi.show', $reservasi->pemesanan_id)
                ->with('error', 'Hanya pembayaran yang menunggu verifikasi yang bisa diverifikasi.');
        }

        $verified = $paymentSettlementService->verify($reservasi->pembayaran, auth()->user()->user_id);

        if (! $verified) {
            return redirect()->route('admin.reservasi.show', $reservasi->pemesanan_id)
                ->with('error', 'Pembayaran sudah diverifikasi sebelumnya.');
        }

        return redirect()->route('admin.reservasi.show', $reservasi->pemesanan_id)
            ->with('success', 'Pembayaran homestay berhasil diverifikasi dan booking dikonfirmasi.');
    }

    /**
     * Tolak pembayaran homestay agar pelanggan bisa mengirim ulang bukti.
     */
    public function rejectPayment(Request $request, $pemesanan_id)
    {
        $validated = $request->validate([
            'catatan_admin' => 'nullable|string|max:1000',
        ]);

        $reservasi = Pemesanan::with('pembayaran')
            ->where('jenis_pemesanan', Pemesanan::JENIS_HOMESTAY)
            ->findOrFail($pemesanan_id);

        if (! $reservasi->pembayaran) {
            return redirect()->route('admin.reservasi.show', $reservasi->pemesanan_id)
                ->with('error', 'Reservasi ini belum memiliki pembayaran.');
        }

        if ($reservasi->pembayaran->status_pembayaran === Pembayaran::STATUS_TERVERIFIKASI) {
            return redirect()->route('admin.reservasi.show', $reservasi->pemesanan_id)
                ->with('error', 'Pembayaran yang sudah terverifikasi tidak dapat ditolak.');
        }

        $reservasi->pembayaran->update([
            'status_pembayaran' => Pembayaran::STATUS_DITOLAK,
            'catatan_admin' => $validated['catatan_admin'] ?? null,
            'verified_at' => null,
            'verified_by' => null,
        ]);

        $reservasi->update([
            'status_pemesanan' => Pemesanan::STATUS_MENUNGGU_PEMBAYARAN,
        ]);

        return redirect()->route('admin.reservasi.show', $reservasi->pemesanan_id)
            ->with('success', 'Pembayaran homestay berhasil ditolak.');
    }
}
