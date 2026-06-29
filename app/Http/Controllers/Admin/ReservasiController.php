<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pemesanan;
use Illuminate\Http\Request;

class ReservasiController extends Controller
{
    /**
     * Tampilkan daftar reservasi untuk admin.
     */
    public function index(Request $request)
    {
        $status = $request->query('status');
        $statuses = [
            Pemesanan::STATUS_MENUNGGU_PEMBAYARAN,
            Pemesanan::STATUS_MENUNGGU_VERIFIKASI,
            Pemesanan::STATUS_DIPROSES,
            Pemesanan::STATUS_DIKONFIRMASI,
            Pemesanan::STATUS_DIBATALKAN,
            Pemesanan::STATUS_SELESAI,
        ];

        $reservasis = Pemesanan::with('user', 'detailPemesanans.homestay', 'pembayaran')
            ->where('jenis_pemesanan', Pemesanan::JENIS_HOMESTAY)
            ->when(in_array($status, $statuses, true), fn ($query) => $query->where('status_pemesanan', $status))
            ->latest('tanggal_pemesanan')
            ->get();

        return view('admin.reservasi.index', compact('reservasis', 'statuses', 'status'));
    }

    /**
     * Tampilkan detail reservasi untuk admin.
     */
    public function show($pemesanan_id)
    {
        $reservasi = Pemesanan::with('user', 'detailPemesanans.homestay', 'pembayaran')
            ->where('jenis_pemesanan', Pemesanan::JENIS_HOMESTAY)
            ->findOrFail($pemesanan_id);

        return view('admin.reservasi.show', compact('reservasi'));
    }

    /**
     * Update status reservasi homestay.
     */
    public function updateStatus(Request $request, $pemesanan_id)
    {
        $validated = $request->validate([
            'status_pemesanan' => 'required|in:'.implode(',', [
                Pemesanan::STATUS_DIPROSES,
                Pemesanan::STATUS_DIKONFIRMASI,
                Pemesanan::STATUS_DIBATALKAN,
                Pemesanan::STATUS_SELESAI,
            ]),
        ]);

        $reservasi = Pemesanan::where('jenis_pemesanan', Pemesanan::JENIS_HOMESTAY)
            ->findOrFail($pemesanan_id);

        $reservasi->update([
            'status_pemesanan' => $validated['status_pemesanan'],
        ]);

        return redirect()->route('admin.reservasi.show', $reservasi->pemesanan_id)
            ->with('success', 'Status reservasi berhasil diperbarui.');
    }
}
