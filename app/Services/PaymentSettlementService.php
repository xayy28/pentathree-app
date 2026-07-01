<?php

namespace App\Services;

use App\Models\Pembayaran;
use App\Models\Pemesanan;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class PaymentSettlementService
{
    /**
     * Verifikasi pembayaran dan jalankan efek transaksi satu kali.
     */
    public function verify(Pembayaran $pembayaran, ?string $verifiedBy = null, array $extraPaymentData = []): bool
    {
        return DB::transaction(function () use ($pembayaran, $verifiedBy, $extraPaymentData) {
            $lockedPayment = Pembayaran::with('pemesanan.detailPemesanans.souvenir')
                ->whereKey($pembayaran->pembayaran_id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($lockedPayment->status_pembayaran === Pembayaran::STATUS_TERVERIFIKASI) {
                return false;
            }

            $pemesanan = $lockedPayment->pemesanan;

            if ($pemesanan->jenis_pemesanan === Pemesanan::JENIS_SOUVENIR) {
                foreach ($pemesanan->detailPemesanans as $detail) {
                    if ($detail->souvenir_id && $detail->souvenir) {
                        if ($detail->souvenir->stok < $detail->jumlah) {
                            throw new RuntimeException("Stok {$detail->souvenir->nama_souvenir} tidak mencukupi untuk verifikasi.");
                        }

                        $detail->souvenir->decrement('stok', $detail->jumlah);
                        $detail->souvenir->increment('jumlah_terjual', $detail->jumlah);
                    }
                }
            }

            $lockedPayment->update(array_merge([
                'status_pembayaran' => Pembayaran::STATUS_TERVERIFIKASI,
                'verified_at' => now(),
                'verified_by' => $verifiedBy,
                'catatan_admin' => null,
            ], $extraPaymentData));

            $pemesanan->update([
                'status_pemesanan' => Pemesanan::STATUS_DIPROSES,
            ]);

            return true;
        });
    }
}
