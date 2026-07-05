<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriHomestay;
use Illuminate\Http\Request;

class KategoriHomestayController extends Controller
{
    /**
     * Tampilkan daftar kategori homestay.
     */
    public function index()
    {
        $categories = KategoriHomestay::withCount('homestays')->latest()->get();

        return view('admin.kategori-homestay.index', compact('categories'));
    }

    /**
     * Tampilkan form tambah kategori.
     */
    public function create()
    {
        return view('admin.kategori-homestay.tambah');
    }

    /**
     * Simpan kategori baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategori_homestays,nama_kategori',
            'deskripsi' => 'nullable|string',
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.unique' => 'Nama kategori ini sudah terdaftar.',
        ]);

        KategoriHomestay::create($request->only(['nama_kategori', 'deskripsi']));

        return redirect()->route('admin.kategori-homestay')->with('success', 'Kategori homestay berhasil ditambahkan.');
    }

    /**
     * Tampilkan form edit kategori.
     */
    public function edit($kategori_id)
    {
        $category = KategoriHomestay::findOrFail($kategori_id);

        return view('admin.kategori-homestay.edit', compact('category'));
    }

    /**
     * Perbarui kategori.
     */
    public function update(Request $request, $kategori_id)
    {
        $category = KategoriHomestay::findOrFail($kategori_id);

        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategori_homestays,nama_kategori,'.$kategori_id.',kategori_id',
            'deskripsi' => 'nullable|string',
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.unique' => 'Nama kategori ini sudah terdaftar.',
        ]);

        $category->update($request->only(['nama_kategori', 'deskripsi']));

        return redirect()->route('admin.kategori-homestay')->with('success', 'Kategori homestay berhasil diperbarui.');
    }

    /**
     * Hapus kategori.
     */
    public function destroy($kategori_id)
    {
        $category = KategoriHomestay::findOrFail($kategori_id);

        // Jika kategori memiliki homestay terkait, cegah penghapusan atau tangani dengan aman
        if ($category->homestays()->count() > 0) {
            return redirect()->route('admin.kategori-homestay')->with('error', 'Kategori ini tidak dapat dihapus karena memiliki homestay terkait.');
        }

        $category->delete();

        return redirect()->route('admin.kategori-homestay')->with('success', 'Kategori homestay berhasil dihapus.');
    }
}
