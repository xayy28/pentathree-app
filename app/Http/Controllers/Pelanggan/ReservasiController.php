<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Homestay;

class ReservasiController extends Controller
{
    /**
     * Tampilkan daftar reservasi untuk pelanggan.
     */
    public function index()
    {
        return redirect()->route('user.pesanan.index');
    }

    /**
     * Tampilkan form buat reservasi untuk homestay tertentu.
     */
    public function create($homestay_id)
    {
        Homestay::findOrFail($homestay_id);

        return redirect()->route('user.homestay.booking.create', $homestay_id);
    }
}
