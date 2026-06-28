<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Pemesanan;

class PemesananController extends Controller
{
    /**
     * Tampilkan riwayat pemesanan pelanggan.
     */
    public function index()
    {
        $pemesanans = Pemesanan::withCount('detailPemesanans')
            ->where('user_id', auth()->user()->user_id)
            ->latest()
            ->get();

        return view('pelanggan.pesanan.index', compact('pemesanans'));
    }

    /**
     * Tampilkan detail pemesanan pelanggan.
     */
    public function show($pemesanan_id)
    {
        $pemesanan = Pemesanan::with('detailPemesanans.souvenir', 'detailPemesanans.homestay')
            ->where('user_id', auth()->user()->user_id)
            ->where('pemesanan_id', $pemesanan_id)
            ->firstOrFail();

        return view('pelanggan.pesanan.show', compact('pemesanan'));
    }
}
