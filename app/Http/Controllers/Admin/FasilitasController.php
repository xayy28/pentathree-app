<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fasilitas;
use Illuminate\Http\Request;

class FasilitasController extends Controller
{
    public function index()
    {
        $fasilitas = Fasilitas::latest()->get();

        return view('admin.fasilitas.index', compact('fasilitas'));
    }

    public function create()
    {
        return view('admin.fasilitas.tambah');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_fasilitas' => 'required|string|max:255|unique:fasilitas,nama_fasilitas',
            'ikon' => 'nullable|string|max:50',
        ], [
            'nama_fasilitas.required' => 'Nama fasilitas wajib diisi.',
            'nama_fasilitas.unique' => 'Nama fasilitas ini sudah terdaftar.',
        ]);

        Fasilitas::create($request->only(['nama_fasilitas', 'ikon']));

        return redirect()->route('admin.fasilitas')->with('success', 'Fasilitas berhasil ditambahkan.');
    }

    public function edit($fasilitas_id)
    {
        $fasilitas = Fasilitas::findOrFail($fasilitas_id);

        return view('admin.fasilitas.edit', compact('fasilitas'));
    }

    public function update(Request $request, $fasilitas_id)
    {
        $fasilitas = Fasilitas::findOrFail($fasilitas_id);

        $request->validate([
            'nama_fasilitas' => 'required|string|max:255|unique:fasilitas,nama_fasilitas,'.$fasilitas_id.',fasilitas_id',
            'ikon' => 'nullable|string|max:50',
        ], [
            'nama_fasilitas.required' => 'Nama fasilitas wajib diisi.',
            'nama_fasilitas.unique' => 'Nama fasilitas ini sudah terdaftar.',
        ]);

        $fasilitas->update($request->only(['nama_fasilitas', 'ikon']));

        return redirect()->route('admin.fasilitas')->with('success', 'Fasilitas berhasil diperbarui.');
    }

    public function destroy($fasilitas_id)
    {
        $fasilitas = Fasilitas::findOrFail($fasilitas_id);

        if ($fasilitas->homestays()->count() > 0) {
            return redirect()->route('admin.fasilitas')->with('error', 'Fasilitas tidak dapat dihapus karena masih digunakan oleh homestay.');
        }

        $fasilitas->delete();

        return redirect()->route('admin.fasilitas')->with('success', 'Fasilitas berhasil dihapus.');
    }
}
