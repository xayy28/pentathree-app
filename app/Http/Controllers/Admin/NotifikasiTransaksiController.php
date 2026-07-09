<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pemesanan;

class NotifikasiTransaksiController extends Controller
{
    public function show($pemesanan_id)
    {
        $pemesanan = Pemesanan::with('pembayaran')->findOrFail($pemesanan_id);

        $pemesanan->tandaiDilihatAdmin();

        if ($pemesanan->jenis_pemesanan === Pemesanan::JENIS_HOMESTAY) {
            return redirect()->route('admin.reservasi.show', $pemesanan->pemesanan_id);
        }

        if ($pemesanan->pembayaran) {
            return redirect()->route('admin.pembayaran.show', $pemesanan->pembayaran->pembayaran_id);
        }

        return redirect()
            ->route('admin.pembayaran')
            ->with('success', 'Transaksi souvenir ditandai sudah dilihat. Pembayaran belum dikirim pelanggan.');
    }
}
