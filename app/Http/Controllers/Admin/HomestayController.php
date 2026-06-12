<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Homestay;
use Illuminate\Http\Request;

class HomestayController extends Controller
{
    /**
     * Tampilkan daftar homestay.
     */
    public function index()
    {
        $homestays = Homestay::latest()->get();
        return view('admin.homestay.index', compact('homestays'));
    }

    /**
     * Tampilkan form tambah homestay.
     */
    public function create()
    {
        return view('admin.homestay.tambah');
    }

    /**
     * Simpan homestay baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_homestay' => 'required|string|max:255',
            'harga_permalam' => 'required|numeric|min:0',
            'kapasitas' => 'required|integer|min:1',
            'status' => 'required|string|max:50',
            'detail' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['nama_homestay', 'harga_permalam', 'kapasitas', 'status', 'detail']);

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/homestays'), $filename);
            $data['foto'] = 'uploads/homestays/' . $filename;
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
        return view('admin.homestay.edit', compact('homestay'));
    }

    /**
     * Update data homestay.
     */
    public function update(Request $request, $homestay_id)
    {
        $homestay = Homestay::findOrFail($homestay_id);

        $request->validate([
            'nama_homestay' => 'required|string|max:255',
            'harga_permalam' => 'required|numeric|min:0',
            'kapasitas' => 'required|integer|min:1',
            'status' => 'required|string|max:50',
            'detail' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $homestay->nama_homestay = $request->nama_homestay;
        $homestay->harga_permalam = $request->harga_permalam;
        $homestay->kapasitas = $request->kapasitas;
        $homestay->status = $request->status;
        $homestay->detail = $request->detail;

        if ($request->hasFile('foto')) {
            if ($homestay->foto && file_exists(public_path($homestay->foto))) {
                @unlink(public_path($homestay->foto));
            }
            $file = $request->file('foto');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/homestays'), $filename);
            $homestay->foto = 'uploads/homestays/' . $filename;
        }

        $homestay->save();

        return redirect()->route('admin.homestay')->with('success', 'Homestay berhasil diperbarui.');
    }

    /**
     * Hapus homestay.
     */
    public function destroy($homestay_id)
    {
        $homestay = Homestay::findOrFail($homestay_id);

        if ($homestay->foto && file_exists(public_path($homestay->foto))) {
            @unlink(public_path($homestay->foto));
        }

        $homestay->delete();

        return redirect()->route('admin.homestay')->with('success', 'Homestay berhasil dihapus.');
    }
}
