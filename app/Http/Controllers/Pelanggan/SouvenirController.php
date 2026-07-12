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
        $cari = substr(trim((string) $request->query('cari', '')), 0, 100);
        $urutkan = $request->query('urutkan', $request->query('kategori') === 'terlaris' ? 'terlaris' : 'terbaru');
        $allowedSorts = ['terbaru', 'terlaris', 'harga_termurah', 'harga_termahal'];

        if (! in_array($urutkan, $allowedSorts, true)) {
            $urutkan = 'terbaru';
        }

        $souvenirQuery = Souvenir::query()
            ->withAvg('ulasans', 'rating')
            ->withCount('ulasans')
            ->when($cari !== '', function ($query) use ($cari) {
                $query->where(function ($searchQuery) use ($cari) {
                    $searchQuery
                        ->where('nama_souvenir', 'like', "%{$cari}%")
                        ->orWhere('detail', 'like', "%{$cari}%");
                });
            });

        match ($urutkan) {
            'terlaris' => $souvenirQuery->orderByDesc('jumlah_terjual')->latest(),
            'harga_termurah' => $souvenirQuery->orderBy('harga')->latest(),
            'harga_termahal' => $souvenirQuery->orderByDesc('harga')->latest(),
            default => $souvenirQuery->latest(),
        };

        $souvenirs = $souvenirQuery->get();

        return view('pelanggan.souvenir.index', compact('souvenirs', 'cari', 'urutkan'));
    }

    /**
     * Tampilkan halaman detail souvenir.
     */
    public function show($souvenir_id)
    {
        $souvenir = Souvenir::with('ulasans.user')
            ->withAvg('ulasans', 'rating')
            ->withCount('ulasans')
            ->findOrFail($souvenir_id);

        // Ambil souvenir lain sebagai rekomendasi (exclude yang sedang dilihat)
        $rekomendasi = Souvenir::withAvg('ulasans', 'rating')
            ->withCount('ulasans')
            ->where('souvenir_id', '!=', $souvenir_id)
            ->where('status', 'Tersedia')
            ->inRandomOrder()
            ->limit(3)
            ->get();

        return view('pelanggan.souvenir.show', compact('souvenir', 'rekomendasi'));
    }
}
