<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\DetailPemesanan;
use App\Models\Pembayaran;
use App\Models\Ulasan;
use Illuminate\Http\Request;

class UlasanController extends Controller
{
    /**
     * Simpan atau perbarui ulasan customer untuk item pesanan yang pembayarannya sudah valid.
     */
    public function store(Request $request, $pemesanan_id, $detail_pemesanan_id)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string|max:1000',
        ]);

        $detail = DetailPemesanan::with('pemesanan.pembayaran')
            ->where('detail_pemesanan_id', $detail_pemesanan_id)
            ->where('pemesanan_id', $pemesanan_id)
            ->whereHas('pemesanan', function ($query) {
                $query->where('user_id', auth()->user()->user_id);
            })
            ->firstOrFail();

        if ($detail->pemesanan->pembayaran?->status_pembayaran !== Pembayaran::STATUS_TERVERIFIKASI) {
            return back()->with('error', 'Ulasan hanya bisa diberikan setelah pembayaran terverifikasi.');
        }

        Ulasan::updateOrCreate(
            ['detail_pemesanan_id' => $detail->detail_pemesanan_id],
            [
                'user_id' => auth()->user()->user_id,
                'pemesanan_id' => $detail->pemesanan_id,
                'homestay_id' => $detail->homestay_id,
                'souvenir_id' => $detail->souvenir_id,
                'rating' => $validated['rating'],
                'komentar' => $validated['komentar'] ?? null,
            ],
        );

        return redirect()->route('user.pesanan.show', $detail->pemesanan_id)
            ->with('success', 'Ulasan berhasil disimpan.');
    }
}
