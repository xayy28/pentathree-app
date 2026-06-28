<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Models\Pemesanan;
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

        if ($pemesanan->pembayaran && $pemesanan->pembayaran->status_pembayaran !== Pembayaran::STATUS_DITOLAK) {
            return redirect()->route('user.pesanan.show', $pemesanan->pemesanan_id)
                ->with('error', 'Pembayaran untuk pesanan ini sudah dikirim atau sudah diverifikasi.');
        }

        return view('pelanggan.pembayaran.create', compact('pemesanan'));
    }

    /**
     * Simpan pembayaran pelanggan.
     */
    public function store(Request $request, $pemesanan_id)
    {
        $pemesanan = Pemesanan::with('pembayaran')
            ->where('user_id', auth()->user()->user_id)
            ->where('pemesanan_id', $pemesanan_id)
            ->firstOrFail();

        if ($pemesanan->pembayaran && $pemesanan->pembayaran->status_pembayaran !== Pembayaran::STATUS_DITOLAK) {
            return redirect()->route('user.pesanan.show', $pemesanan->pemesanan_id)
                ->with('error', 'Pembayaran untuk pesanan ini sudah dikirim atau sudah diverifikasi.');
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

        $validated['bukti_pembayaran'] = $request->file('bukti_pembayaran')->store('uploads/bukti_pembayaran', 'public');
        $validated['tanggal_pembayaran'] = now();
        $validated['status_pembayaran'] = Pembayaran::STATUS_MENUNGGU_VERIFIKASI;
        $validated['catatan_admin'] = null;
        $validated['verified_at'] = null;
        $validated['verified_by'] = null;

        Pembayaran::updateOrCreate(
            ['pemesanan_id' => $pemesanan->pemesanan_id],
            $validated
        );

        $pemesanan->update([
            'status_pemesanan' => Pemesanan::STATUS_MENUNGGU_VERIFIKASI,
        ]);

        return redirect()->route('user.pesanan.show', $pemesanan->pemesanan_id)
            ->with('success', 'Bukti pembayaran berhasil dikirim dan menunggu verifikasi admin.');
    }
}
