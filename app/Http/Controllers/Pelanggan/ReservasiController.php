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
        return view('pelanggan.reservasi.index');
    }

    /**
     * Tampilkan form buat reservasi untuk homestay tertentu.
     */
    public function create($homestay_id)
    {
        $homestay = Homestay::with('kategori')->findOrFail($homestay_id);
        return view('pelanggan.reservasi.create', compact('homestay'));
    }
}