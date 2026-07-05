<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Homestay;
use App\Models\KategoriHomestay;
use App\Models\Pemesanan;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;

class HomestayController extends Controller
{
    /**
     * Tampilkan daftar homestay.
     */
    public function index(Request $request)
    {
        $kategori = $request->query('kategori');
        $status = $request->query('status');
        $statuses = ['Tersedia', 'Tidak Tersedia'];
        $categories = KategoriHomestay::orderBy('nama_kategori')->get();

        $homestays = Homestay::with('kategori')
            ->when($kategori, fn ($query) => $query->where('kategori_id', $kategori))
            ->when(in_array($status, $statuses, true), fn ($query) => $query->where('status', $status))
            ->latest()
            ->get();

        return view('admin.homestay.index', compact('homestays', 'categories', 'kategori', 'status', 'statuses'));
    }

    /**
     * Tampilkan form tambah homestay.
     */
    public function create()
    {
        $categories = KategoriHomestay::all();

        return view('admin.homestay.tambah', compact('categories'));
    }

    /**
     * Simpan homestay baru.
     */
    public function store(Request $request, ImageUploadService $imageUploadService)
    {
        $request->validate([
            'kategori_id' => 'nullable|exists:kategori_homestays,kategori_id',
            'nama_homestay' => 'required|string|max:255',
            'harga_permalam' => 'required|numeric|min:0',
            'kapasitas' => 'required|integer|min:1',
            'status' => 'required|in:Tersedia,Tidak Tersedia',
            'detail' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = $request->only(['kategori_id', 'nama_homestay', 'harga_permalam', 'kapasitas', 'status', 'detail']);

        if ($request->hasFile('foto')) {
            $data['foto'] = $imageUploadService->storePublic(
                $request->file('foto'),
                'uploads/homestays',
                maxWidth: 1600,
                maxHeight: 1000
            );
        }

        Homestay::create($data);

        return redirect()->route('admin.homestay')->with('success', 'Homestay berhasil ditambahkan.');
    }

    /**
     * Tampilkan form edit homestay.
     */
    public function edit($homestay_id)
    {
        $homestay = Homestay::findOrFail($homestay_id);
        $categories = KategoriHomestay::all();

        return view('admin.homestay.edit', compact('homestay', 'categories'));
    }

    /**
     * Update data homestay.
     */
    public function update(Request $request, $homestay_id, ImageUploadService $imageUploadService)
    {
        $homestay = Homestay::findOrFail($homestay_id);

        $request->validate([
            'kategori_id' => 'nullable|exists:kategori_homestays,kategori_id',
            'nama_homestay' => 'required|string|max:255',
            'harga_permalam' => 'required|numeric|min:0',
            'kapasitas' => 'required|integer|min:1',
            'status' => 'required|in:Tersedia,Tidak Tersedia',
            'detail' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $homestay->kategori_id = $request->kategori_id;
        $homestay->nama_homestay = $request->nama_homestay;
        $homestay->harga_permalam = $request->harga_permalam;
        $homestay->kapasitas = $request->kapasitas;
        $homestay->status = $request->status;
        $homestay->detail = $request->detail;

        if ($request->hasFile('foto')) {
            if ($homestay->foto && file_exists(public_path($homestay->foto))) {
                @unlink(public_path($homestay->foto));
            }
            $homestay->foto = $imageUploadService->storePublic(
                $request->file('foto'),
                'uploads/homestays',
                maxWidth: 1600,
                maxHeight: 1000
            );
        }

        $homestay->save();

        return redirect()->route('admin.homestay')->with('success', 'Homestay berhasil diperbarui.');
    }

    /**
     * Hapus homestay.
     */
    public function destroy($homestay_id)
    {
        $homestay = Homestay::with('detailPemesanans.pemesanan')->findOrFail($homestay_id);

        $hasActiveReservation = $homestay->detailPemesanans
            ->contains(fn ($detail) => $detail->pemesanan
                && $detail->pemesanan->jenis_pemesanan === Pemesanan::JENIS_HOMESTAY
                && ! in_array($detail->pemesanan->status_pemesanan, [
                    Pemesanan::STATUS_DIBATALKAN,
                    Pemesanan::STATUS_SELESAI,
                ], true));

        if ($hasActiveReservation) {
            return redirect()->route('admin.homestay')
                ->with('error', 'Homestay tidak dapat dihapus karena masih memiliki reservasi aktif.');
        }

        if ($homestay->foto && file_exists(public_path($homestay->foto))) {
            @unlink(public_path($homestay->foto));
        }

        $homestay->delete();

        return redirect()->route('admin.homestay')->with('success', 'Homestay berhasil dihapus.');
    }
}
