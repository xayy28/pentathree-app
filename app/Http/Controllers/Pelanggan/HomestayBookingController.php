<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\DetailPemesanan;
use App\Models\Homestay;
use App\Models\Pemesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class HomestayBookingController extends Controller
{
    /**
     * Tampilkan form booking homestay.
     */
    public function create($homestay_id)
    {
        $homestay = Homestay::with('kategori')->findOrFail($homestay_id);

        if ($homestay->status !== 'Tersedia') {
            return redirect()->route('user.homestay')
                ->with('error', 'Homestay ini sedang tidak tersedia.');
        }

        return view('pelanggan.homestay.booking', compact('homestay'));
    }

    /**
     * Simpan booking homestay sebagai pemesanan.
     */
    public function store(Request $request, $homestay_id)
    {
        $homestay = Homestay::findOrFail($homestay_id);

        if ($homestay->status !== 'Tersedia') {
            return redirect()->route('user.homestay')
                ->with('error', 'Homestay ini sedang tidak tersedia.');
        }

        $validated = $request->validate([
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
            'jumlah_tamu' => 'required|integer|min:1|max:'.$homestay->kapasitas,
            'catatan' => 'nullable|string|max:500',
        ], [
            'check_in.after_or_equal' => 'Tanggal check-in tidak boleh sebelum hari ini.',
            'check_out.after' => 'Tanggal check-out harus setelah tanggal check-in.',
            'jumlah_tamu.max' => 'Jumlah tamu melebihi kapasitas homestay.',
        ]);

        $checkIn = Carbon::parse($validated['check_in']);
        $checkOut = Carbon::parse($validated['check_out']);
        $jumlahMalam = $checkIn->diffInDays($checkOut);
        $subtotal = $homestay->harga_permalam * $jumlahMalam;

        $pemesanan = DB::transaction(function () use ($homestay, $validated, $jumlahMalam, $subtotal) {
            $pemesanan = Pemesanan::create([
                'user_id' => auth()->user()->user_id,
                'jenis_pemesanan' => Pemesanan::JENIS_HOMESTAY,
                'total_harga' => $subtotal,
                'status_pemesanan' => Pemesanan::STATUS_MENUNGGU_PEMBAYARAN,
            ]);

            DetailPemesanan::create([
                'pemesanan_id' => $pemesanan->pemesanan_id,
                'homestay_id' => $homestay->homestay_id,
                'nama_item' => $homestay->nama_homestay,
                'harga' => $homestay->harga_permalam,
                'jumlah' => 1,
                'check_in' => $validated['check_in'],
                'check_out' => $validated['check_out'],
                'jumlah_malam' => $jumlahMalam,
                'subtotal' => $subtotal,
            ]);

            return $pemesanan;
        });

        return redirect()->route('user.pembayaran.create', $pemesanan->pemesanan_id)
            ->with('success', 'Booking homestay berhasil dibuat. Silakan pilih metode pembayaran.');
    }
}
