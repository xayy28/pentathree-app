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
}
