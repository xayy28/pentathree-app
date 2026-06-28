<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Keranjang;
use App\Models\KeranjangItem;
use App\Models\Souvenir;
use Illuminate\Http\Request;

class KeranjangController extends Controller
{
    /**
     * Tampilkan semua item di keranjang belanja user.
     */
    public function index()
    {
        $keranjang = Keranjang::with('keranjangItems.souvenir')
            ->where('user_id', auth()->user()->user_id)
            ->first();

        $items = $keranjang ? $keranjang->keranjangItems : collect();

        return view('pelanggan.souvenir.keranjang', compact('items'));
    }

    /**
     * Tampilkan halaman checkout.
     */
    public function checkout()
    {
        $keranjang = Keranjang::with('keranjangItems.souvenir')
            ->where('user_id', auth()->user()->user_id)
            ->first();

        $items = $keranjang ? $keranjang->keranjangItems : collect();

        // Jika kosong, redirect kembali ke keranjang
        if ($items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong.');
        }

        return view('pelanggan.souvenir.checkout', compact('items'));
    }

    /**
     * Tambahkan item baru atau perbarui jumlah item di keranjang.
     */
    public function addToCart(Request $request)
    {
        $request->validate([
            'souvenir_id' => 'required|exists:souvenirs,souvenir_id',
            'quantity' => 'required|integer|min:1',
        ]);

        $souvenir = Souvenir::findOrFail($request->souvenir_id);
        $quantityToAdd = (int) $request->quantity;

        // Cek ketersediaan status souvenir
        if ($souvenir->status !== 'Tersedia' || $souvenir->stok <= 0) {
            return redirect()->back()->with('error', 'Souvenir ini sedang tidak tersedia atau stok habis.');
        }

        // Cari atau buat keranjang induk untuk user
        $keranjang = Keranjang::firstOrCreate([
            'user_id' => auth()->user()->user_id,
        ]);

        // Cari apakah item souvenir ini sudah ada di keranjang
        $cartItem = KeranjangItem::where('id_keranjang', $keranjang->id)
            ->where('souvenir_id', $souvenir->souvenir_id)
            ->first();

        $existingQty = $cartItem ? $cartItem->quantity : 0;
        $newQty = $existingQty + $quantityToAdd;

        // Validasi kecukupan stok souvenir
        if ($newQty > $souvenir->stok) {
            return redirect()->back()->with('error', "Stok tidak mencukupi. Anda sudah memiliki {$existingQty} di keranjang, dan stok maksimal adalah {$souvenir->stok}.");
        }

        if ($cartItem) {
            $cartItem->update(['quantity' => $newQty]);
        } else {
            KeranjangItem::create([
                'id_keranjang' => $keranjang->id,
                'souvenir_id' => $souvenir->souvenir_id,
                'quantity' => $quantityToAdd,
            ]);
        }

        return redirect()->back()->with('success', 'Souvenir berhasil ditambahkan ke keranjang.');
    }

    /**
     * Ubah kuantitas item dalam keranjang.
     */
    public function updateQuantity(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:keranjang_items,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = KeranjangItem::findOrFail($request->id);

        // Pastikan keranjang ini milik user yang sedang login
        if ($cartItem->keranjang->user_id !== auth()->user()->user_id) {
            return redirect()->back()->with('error', 'Aksi tidak diizinkan.');
        }

        $souvenir = $cartItem->souvenir;
        $newQty = (int) $request->quantity;

        // Validasi kecukupan stok
        if ($newQty > $souvenir->stok) {
            return redirect()->back()->with('error', "Stok tidak mencukupi. Stok maksimal adalah {$souvenir->stok}.");
        }

        $cartItem->update(['quantity' => $newQty]);

        return redirect()->back()->with('success', 'Jumlah barang berhasil diperbarui.');
    }

    /**
     * Hapus item dari keranjang.
     */
    public function destroy($id)
    {
        $cartItem = KeranjangItem::findOrFail($id);

        // Pastikan keranjang ini milik user yang sedang login
        if ($cartItem->keranjang->user_id !== auth()->user()->user_id) {
            return redirect()->back()->with('error', 'Aksi tidak diizinkan.');
        }

        $cartItem->delete();

        return redirect()->back()->with('success', 'Item berhasil dihapus dari keranjang.');
    }
}
