<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Models\Pemesanan;
use App\Services\MidtransPaymentService;
use App\Services\MidtransPaymentStatusService;
use Illuminate\Http\JsonResponse;
use RuntimeException;

class MidtransPaymentController extends Controller
{
    public function token($pemesanan_id, MidtransPaymentService $midtransPaymentService): JsonResponse
    {
        $pemesanan = Pemesanan::with('user', 'detailPemesanans', 'pembayaran')
            ->where('user_id', auth()->user()->user_id)
            ->where('pemesanan_id', $pemesanan_id)
            ->firstOrFail();

        if ($pemesanan->pembayaran?->status_pembayaran === Pembayaran::STATUS_TERVERIFIKASI) {
            return response()->json([
                'message' => 'Pesanan ini sudah dibayar.',
            ], 422);
        }

        if (
            $pemesanan->pembayaran
            && $pemesanan->pembayaran->metode_pembayaran !== 'midtrans'
            && $pemesanan->pembayaran->status_pembayaran !== Pembayaran::STATUS_DITOLAK
        ) {
            return response()->json([
                'message' => 'Pesanan ini sudah memiliki pembayaran manual yang sedang diproses.',
            ], 422);
        }

        if ($configurationError = $this->midtransConfigurationError()) {
            return response()->json([
                'message' => $configurationError,
            ], 503);
        }

        $pembayaran = $pemesanan->pembayaran ?? new Pembayaran([
            'pemesanan_id' => $pemesanan->pemesanan_id,
        ]);

        if (
            ! $pembayaran->exists
            || $pembayaran->status_pembayaran === Pembayaran::STATUS_DITOLAK
            || blank($pembayaran->midtrans_snap_token)
        ) {
            $pembayaran->fill([
                'metode_pembayaran' => 'midtrans',
                'jumlah_bayar' => $pemesanan->total_harga,
                'bukti_pembayaran' => null,
                'tanggal_pembayaran' => now(),
                'status_pembayaran' => Pembayaran::STATUS_MENUNGGU_PEMBAYARAN,
                'catatan_admin' => null,
                'verified_at' => null,
                'verified_by' => null,
                'midtrans_order_id' => $this->midtransOrderId($pemesanan),
                'midtrans_transaction_id' => null,
                'midtrans_transaction_status' => null,
                'midtrans_fraud_status' => null,
                'midtrans_payment_type' => null,
                'midtrans_va_number' => null,
                'midtrans_payment_code' => null,
                'midtrans_snap_token' => null,
                'midtrans_redirect_url' => null,
                'midtrans_payload' => null,
                'paid_at' => null,
            ])->save();

            try {
                $snapToken = $midtransPaymentService->createSnapToken($pemesanan, $pembayaran);
            } catch (RuntimeException $exception) {
                return response()->json([
                    'message' => $exception->getMessage(),
                ], 503);
            }

            $pembayaran->update([
                'midtrans_snap_token' => $snapToken,
            ]);

            $pemesanan->update([
                'status_pemesanan' => Pemesanan::STATUS_MENUNGGU_PEMBAYARAN,
            ]);
        }

        return response()->json([
            'snap_token' => $pembayaran->fresh()->midtrans_snap_token,
            'client_key' => config('midtrans.client_key'),
            'order_id' => $pembayaran->fresh()->midtrans_order_id,
        ]);
    }

    public function status(
        $pemesanan_id,
        MidtransPaymentService $midtransPaymentService,
        MidtransPaymentStatusService $midtransPaymentStatusService
    ): JsonResponse {
        $pemesanan = Pemesanan::with('pembayaran')
            ->where('user_id', auth()->user()->user_id)
            ->where('pemesanan_id', $pemesanan_id)
            ->firstOrFail();

        $pembayaran = $pemesanan->pembayaran;

        if (! $pembayaran || $pembayaran->metode_pembayaran !== 'midtrans') {
            return response()->json([
                'message' => 'Pembayaran Midtrans belum tersedia untuk pesanan ini.',
            ], 422);
        }

        try {
            $payload = $midtransPaymentService->checkTransactionStatus($pembayaran);
            $midtransPaymentStatusService->apply($pembayaran, $payload);
        } catch (RuntimeException $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
            ], 503);
        }

        $pembayaran->refresh();
        $pemesanan->refresh();

        return response()->json([
            'message' => 'Status pembayaran Midtrans berhasil diperbarui.',
            'pembayaran_status' => $pembayaran->status_pembayaran,
            'pemesanan_status' => $pemesanan->status_pemesanan,
            'midtrans_status' => $pembayaran->midtrans_transaction_status,
        ]);
    }

    private function midtransOrderId(Pemesanan $pemesanan): string
    {
        return 'MT-'.$pemesanan->kode_pemesanan.'-'.now()->format('His').'-'.random_int(100, 999);
    }

    private function midtransConfigurationError(): ?string
    {
        $serverKey = (string) config('midtrans.server_key');
        $clientKey = (string) config('midtrans.client_key');
        $isProduction = (bool) config('midtrans.is_production');

        if (blank($serverKey) || blank($clientKey)) {
            return 'Konfigurasi Midtrans Sandbox belum lengkap. Isi MIDTRANS_SERVER_KEY dan MIDTRANS_CLIENT_KEY di .env.';
        }

        if (! $this->hasValidMidtransKeyFormat($serverKey, 'server') || ! $this->hasValidMidtransKeyFormat($clientKey, 'client')) {
            return 'Format MIDTRANS_SERVER_KEY atau MIDTRANS_CLIENT_KEY tidak valid. Copy key persis dari menu Access Keys Midtrans.';
        }

        if ($isProduction && (str_starts_with($serverKey, 'SB-Mid-server-') || str_starts_with($clientKey, 'SB-Mid-client-'))) {
            return 'Mode Midtrans Production tidak boleh memakai key Sandbox.';
        }

        return null;
    }

    private function hasValidMidtransKeyFormat(string $key, string $type): bool
    {
        return str_starts_with($key, "Mid-{$type}-")
            || str_starts_with($key, "SB-Mid-{$type}-");
    }
}
