<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Souvenir;
use Illuminate\Http\Request;

class SouvenirController extends Controller
{
    /**
     * Tampilkan daftar souvenir untuk pelanggan.
     */
    public function index(Request $request)
    {
        $kategori = $request->query('kategori');

        if ($kategori === 'terlaris') {
            $souvenirs = Souvenir::orderBy('jumlah_terjual', 'desc')->get();
        } else {
            $souvenirs = Souvenir::latest()->get();
        }

        return view('pelanggan.souvenir.index', compact('souvenirs', 'kategori'));
    }

    /**
     * Tampilkan halaman detail souvenir.
     */
    public function show($souvenir_id)
    {
        $souvenir = Souvenir::findOrFail($souvenir_id);

        // Ambil souvenir lain sebagai rekomendasi (exclude yang sedang dilihat)
        $rekomendasi = Souvenir::where('souvenir_id', '!=', $souvenir_id)
            ->where('status', 'Tersedia')
            ->inRandomOrder()
            ->limit(3)
            ->get();

        return view('pelanggan.souvenir.show', compact('souvenir', 'rekomendasi'));
    }


}
