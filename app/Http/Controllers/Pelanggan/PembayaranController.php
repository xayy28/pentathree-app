<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Models\Pemesanan;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PembayaranController extends Controller
{
    /**
     * Tampilkan form pembayaran pelanggan.
     */
    public function create($pemesanan_id)
    {
        $pemesanan = Pemesanan::with('pembayaran')
            ->where('user_id', auth()->user()->user_id)
            ->where('pemesanan_id', $pemesanan_id)
            ->firstOrFail();

        if (! $this->canOpenPaymentPage($pemesanan)) {
            return redirect()->route('user.pesanan.index')
                ->with('error', 'Pembayaran untuk pesanan ini sudah dikirim atau sudah diverifikasi.');
        }

        return view('pelanggan.pembayaran.create', compact('pemesanan'));
    }

    /**
     * Simpan pembayaran pelanggan.
     */
    public function store(Request $request, $pemesanan_id, ImageUploadService $imageUploadService)
    {
        $pemesanan = Pemesanan::with('pembayaran')
            ->where('user_id', auth()->user()->user_id)
            ->where('pemesanan_id', $pemesanan_id)
            ->firstOrFail();

        if (! $this->canOpenPaymentPage($pemesanan)) {
            return redirect()->route('user.pesanan.index')
                ->with('error', 'Pembayaran untuk pesanan ini sudah dikirim atau sudah diverifikasi.');
        }

        if ($pemesanan->pembayaran?->metode_pembayaran === 'midtrans') {
            return redirect()->route('user.pembayaran.create', $pemesanan->pemesanan_id)
                ->with('error', 'Metode pembayaran sudah dikunci ke Midtrans untuk pesanan ini.');
        }

        $validated = $request->validate([
            'metode_pembayaran' => 'required|in:transfer_bank,qris_manual,tunai',
            'jumlah_bayar' => 'required|numeric|min:1',
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ((float) $validated['jumlah_bayar'] < (float) $pemesanan->total_harga) {
            return back()
                ->withErrors(['jumlah_bayar' => 'Jumlah bayar tidak boleh kurang dari total pesanan.'])
                ->withInput();
        }

        if ($pemesanan->pembayaran?->bukti_pembayaran) {
            Storage::disk('public')->delete($pemesanan->pembayaran->bukti_pembayaran);
        }

        $validated['bukti_pembayaran'] = $imageUploadService->storeDisk(
            $request->file('bukti_pembayaran'),
            'uploads/bukti_pembayaran',
            maxWidth: 1800,
            maxHeight: 1800,
            quality: 90
        );
        $validated['tanggal_pembayaran'] = now();
        $validated['status_pembayaran'] = Pembayaran::STATUS_MENUNGGU_VERIFIKASI;
        $validated['catatan_admin'] = null;
        $validated['verified_at'] = null;
        $validated['verified_by'] = null;
        $validated['midtrans_order_id'] = null;
        $validated['midtrans_transaction_id'] = null;
        $validated['midtrans_transaction_status'] = null;
        $validated['midtrans_fraud_status'] = null;
        $validated['midtrans_payment_type'] = null;
        $validated['midtrans_va_number'] = null;
        $validated['midtrans_payment_code'] = null;
        $validated['midtrans_snap_token'] = null;
        $validated['midtrans_redirect_url'] = null;
        $validated['midtrans_payload'] = null;
        $validated['paid_at'] = null;

        Pembayaran::updateOrCreate(
            ['pemesanan_id' => $pemesanan->pemesanan_id],
            $validated
        );

        $pemesanan->update([
            'status_pemesanan' => Pemesanan::STATUS_MENUNGGU_VERIFIKASI,
        ]);

        return redirect()->route('user.pesanan.index')
            ->with('success', 'Bukti pembayaran berhasil dikirim dan menunggu verifikasi admin.');
    }

    private function canOpenPaymentPage(Pemesanan $pemesanan): bool
    {
        if (! $pemesanan->pembayaran || $pemesanan->pembayaran->status_pembayaran === Pembayaran::STATUS_DITOLAK) {
            return true;
        }

        return $pemesanan->pembayaran->metode_pembayaran === 'midtrans'
            && $pemesanan->pembayaran->status_pembayaran === Pembayaran::STATUS_MENUNGGU_PEMBAYARAN;
    }
}
