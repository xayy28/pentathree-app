<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Homestay;
use App\Models\KategoriHomestay;

class HomestayController extends Controller
{
    /**
     * Tampilkan daftar homestay untuk pelanggan.
     */
    public function index()
    {
        $homestays = Homestay::with('kategori')->latest()->get();
        $categories = KategoriHomestay::all();

        return view('pelanggan.homestay.index', compact('homestays', 'categories'));
    }
}
