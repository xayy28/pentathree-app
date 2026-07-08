<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Homestay;
use App\Models\KategoriHomestay;
use Illuminate\Http\Request;

class HomestayController extends Controller
{
    /**
     * Tampilkan daftar homestay untuk pelanggan.
     */
    public function index(Request $request)
    {
        $kategori = $request->query('kategori');
        $status = $request->query('status');
        $tamu = $request->query('tamu');
        $statuses = ['Tersedia', 'Tidak Tersedia'];

        $homestays = Homestay::with('kategori')
            ->withAvg('ulasans', 'rating')
            ->withCount('ulasans')
            ->when($kategori, fn ($query) => $query->where('kategori_id', $kategori))
            ->when(in_array($status, $statuses, true), fn ($query) => $query->where('status', $status))
            ->when(is_numeric($tamu) && (int) $tamu > 0, fn ($query) => $query->where('kapasitas', '>=', (int) $tamu))
            ->latest()
            ->get();
        $categories = KategoriHomestay::orderBy('nama_kategori')->get();

        return view('pelanggan.homestay.index', compact('homestays', 'categories', 'kategori', 'status', 'statuses', 'tamu'));
    }

    /**
     * Tampilkan detail homestay untuk pelanggan.
     */
    public function show($homestay_id)
    {
        $homestay = Homestay::with('kategori', 'ulasans.user')
            ->withAvg('ulasans', 'rating')
            ->withCount('ulasans')
            ->findOrFail($homestay_id);

        $rekomendasi = Homestay::with('kategori')
            ->withAvg('ulasans', 'rating')
            ->withCount('ulasans')
            ->where('homestay_id', '!=', $homestay->homestay_id)
            ->where('status', 'Tersedia')
            ->inRandomOrder()
            ->limit(3)
            ->get();

        return view('pelanggan.homestay.show', compact('homestay', 'rekomendasi'));
    }
}
