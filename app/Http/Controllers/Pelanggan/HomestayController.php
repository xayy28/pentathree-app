<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Homestay;
use Illuminate\Http\Request;

class HomestayController extends Controller
{
    /**
     * Tampilkan daftar homestay untuk pelanggan.
     */
    public function index()
    {
        $homestays = Homestay::with('kategori')->latest()->get();
        $categories = \App\Models\KategoriHomestay::all();
        return view('pelanggan.homestay.index', compact('homestays', 'categories'));
    }
}
