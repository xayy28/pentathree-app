<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Souvenir;
use Illuminate\Http\Request;

class SouvenirController extends Controller
{
    /**
     * Tampilkan daftar souvenir untuk admin.
     */
    public function index(Request $request)
    {
        $status = $request->query('status');
        $statuses = ['Tersedia', 'Habis'];

        $souvenirs = Souvenir::with('updater')
            ->when(in_array($status, $statuses, true), fn ($query) => $query->where('status', $status))
            ->latest()
            ->get();

        return view('admin.souvenir.index', compact('souvenirs', 'status', 'statuses'));
    }

    /**
     * Tampilkan form tambah souvenir.
     */
    public function create()
    {
        return view('admin.souvenir.tambah');
    }

    /**
     * Simpan souvenir baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_souvenir' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'status' => 'required|in:Tersedia,Habis',
            'detail' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['nama_souvenir', 'harga', 'stok', 'status', 'detail']);
        $data['updated_by'] = auth()->user()->user_id;

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads/souvenirs'), $filename);
            $data['foto'] = 'uploads/souvenirs/'.$filename;
        }

        Souvenir::create($data);

        return redirect()->route('admin.souvenir')->with('success', 'Souvenir berhasil ditambahkan.');
    }

    /**
     * Tampilkan form edit souvenir.
     */
    public function edit($souvenir_id)
    {
        $souvenir = Souvenir::findOrFail($souvenir_id);

        return view('admin.souvenir.edit', compact('souvenir'));
    }

    /**
     * Update data souvenir.
     */
    public function update(Request $request, $souvenir_id)
    {
        $souvenir = Souvenir::findOrFail($souvenir_id);

        $request->validate([
            'nama_souvenir' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'status' => 'required|in:Tersedia,Habis',
            'detail' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $souvenir->nama_souvenir = $request->nama_souvenir;
        $souvenir->harga = $request->harga;
        $souvenir->stok = $request->stok;
        $souvenir->status = $request->status;
        $souvenir->detail = $request->detail;
        $souvenir->updated_by = auth()->user()->user_id;

        if ($request->hasFile('foto')) {
            if ($souvenir->foto && file_exists(public_path($souvenir->foto))) {
                @unlink(public_path($souvenir->foto));
            }
            $file = $request->file('foto');
            $filename = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads/souvenirs'), $filename);
            $souvenir->foto = 'uploads/souvenirs/'.$filename;
        }

        $souvenir->save();

        return redirect()->route('admin.souvenir')->with('success', 'Souvenir berhasil diperbarui.');
    }

    /**
     * Hapus souvenir.
     */
    public function destroy($souvenir_id)
    {
        $souvenir = Souvenir::findOrFail($souvenir_id);

        if ($souvenir->foto && file_exists(public_path($souvenir->foto))) {
            @unlink(public_path($souvenir->foto));
        }

        $souvenir->delete();

        return redirect()->route('admin.souvenir')->with('success', 'Souvenir berhasil dihapus.');
    }
}
