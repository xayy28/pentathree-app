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
        $status = $request->query('status');
        $statuses = ['Tersedia', 'Habis'];

        $souvenirs = Souvenir::query()
            ->when(in_array($status, $statuses, true), fn ($query) => $query->where('status', $status))
            ->when($kategori === 'terlaris',
                fn ($query) => $query->orderByDesc('jumlah_terjual'),
                fn ($query) => $query->latest(),
            )
            ->get();

        return view('pelanggan.souvenir.index', compact('souvenirs', 'kategori', 'status', 'statuses'));
    }
}
