<?php

namespace App\Services;

use App\Models\Invoice;
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
            $lockedPayment = Pembayaran::with('pemesanan.detailPemesanans.souvenir', 'pemesanan.invoice')
                ->whereKey($pembayaran->pembayaran_id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($lockedPayment->status_pembayaran === Pembayaran::STATUS_TERVERIFIKASI) {
                $this->issueInvoice($lockedPayment);

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
                'status_pemesanan' => $pemesanan->jenis_pemesanan === Pemesanan::JENIS_HOMESTAY
                    ? Pemesanan::STATUS_DIKONFIRMASI
                    : Pemesanan::STATUS_DIPROSES,
            ]);

            $this->issueInvoice($lockedPayment);

            return true;
        });
    }

    private function issueInvoice(Pembayaran $pembayaran): Invoice
    {
        $pemesanan = $pembayaran->pemesanan;
        $invoice = Invoice::firstOrNew([
            'pemesanan_id' => $pemesanan->pemesanan_id,
        ]);

        if (! $invoice->exists) {
            $invoice->fill([
                'pembayaran_id' => $pembayaran->pembayaran_id,
                'tanggal_invoice' => $pembayaran->verified_at ?? $pembayaran->paid_at ?? now(),
                'total_tagihan' => $pemesanan->total_harga,
                'status_invoice' => Invoice::STATUS_TERBIT,
            ])->save();

            return $invoice;
        }

        if (! $invoice->pembayaran_id) {
            $invoice->update([
                'pembayaran_id' => $pembayaran->pembayaran_id,
            ]);
        }

        return $invoice;
    }
}
