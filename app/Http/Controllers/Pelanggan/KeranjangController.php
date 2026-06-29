<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\DetailPemesanan;
use App\Models\Keranjang;
use App\Models\KeranjangItem;
use App\Models\Pemesanan;
use App\Models\Souvenir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
     * Simpan isi keranjang menjadi pemesanan souvenir.
     */
    public function storeCheckout(Request $request)
    {
        $validated = $request->validate([
            'pengiriman' => 'required|in:pickup,ekspedisi,instan',
        ]);

        $keranjang = Keranjang::with('keranjangItems.souvenir')
            ->where('user_id', auth()->user()->user_id)
            ->first();

        $items = $keranjang ? $keranjang->keranjangItems : collect();

        if ($items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong.');
        }

        foreach ($items as $item) {
            $souvenir = $item->souvenir;

            if (! $souvenir || $souvenir->status !== 'Tersedia' || $souvenir->stok <= 0) {
                return redirect()->route('cart.index')->with('error', 'Ada souvenir yang sedang tidak tersedia atau stok habis.');
            }

            if ($item->quantity > $souvenir->stok) {
                return redirect()->route('cart.index')->with('error', "Stok {$souvenir->nama_souvenir} tidak mencukupi. Stok maksimal adalah {$souvenir->stok}.");
            }
        }

        $pemesanan = DB::transaction(function () use ($items, $keranjang, $validated) {
            $subtotal = $items->sum(function ($item) {
                return $item->souvenir->harga * $item->quantity;
            });
            $serviceFee = 5000;
            $shippingFee = $this->shippingFee($validated['pengiriman']);
            $total = $subtotal + $serviceFee + $shippingFee;

            $pemesanan = Pemesanan::create([
                'user_id' => auth()->user()->user_id,
                'jenis_pemesanan' => Pemesanan::JENIS_SOUVENIR,
                'total_harga' => $total,
                'status_pemesanan' => Pemesanan::STATUS_MENUNGGU_PEMBAYARAN,
            ]);

            foreach ($items as $item) {
                DetailPemesanan::create([
                    'pemesanan_id' => $pemesanan->pemesanan_id,
                    'souvenir_id' => $item->souvenir->souvenir_id,
                    'nama_item' => $item->souvenir->nama_souvenir,
                    'harga' => $item->souvenir->harga,
                    'jumlah' => $item->quantity,
                    'subtotal' => $item->souvenir->harga * $item->quantity,
                ]);
            }

            $keranjang->keranjangItems()->delete();

            return $pemesanan;
        });

        return redirect()
            ->route('user.pesanan.show', $pemesanan->pemesanan_id)
            ->with('success', 'Pemesanan berhasil dibuat. Silakan lanjutkan pembayaran.');
    }

    /**
     * Tambahkan item baru atau perbarui jumlah item di keranjang.
     */
    public function addToCart(Request $request)
    {
        $request->validate([
            'souvenir_id' => 'required|exists:souvenirs,souvenir_id',
            'quantity' => 'required|integer|min:1',
            'redirect_to' => 'nullable|in:cart,checkout',
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

        if ($request->input('redirect_to') === 'checkout') {
            return redirect()->route('checkout.index')->with('success', 'Souvenir berhasil ditambahkan ke keranjang.');
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

    private function shippingFee(string $pengiriman): int
    {
        return match ($pengiriman) {
            'ekspedisi' => 15000,
            'instan' => 20000,
            default => 0,
        };
    }
}
