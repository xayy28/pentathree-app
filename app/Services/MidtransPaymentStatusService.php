<?php

namespace App\Services;

use App\Models\Pembayaran;
use App\Models\Pemesanan;

class MidtransPaymentStatusService
{
    public function __construct(private readonly PaymentSettlementService $paymentSettlementService) {}

    public function apply(Pembayaran $pembayaran, array $payload): void
    {
        $transactionStatus = $payload['transaction_status'] ?? null;
        $fraudStatus = $payload['fraud_status'] ?? null;
        $commonData = [
            'midtrans_transaction_id' => $payload['transaction_id'] ?? null,
            'midtrans_transaction_status' => $transactionStatus,
            'midtrans_fraud_status' => $fraudStatus,
            'midtrans_payment_type' => $payload['payment_type'] ?? null,
            'midtrans_va_number' => $this->extractVaNumber($payload),
            'midtrans_payment_code' => $this->extractPaymentCode($payload),
            'midtrans_payload' => $payload,
        ];

        if ($transactionStatus === 'settlement' || ($transactionStatus === 'capture' && $fraudStatus !== 'challenge')) {
            $this->paymentSettlementService->verify($pembayaran, null, array_merge($commonData, [
                'paid_at' => now(),
                'metode_pembayaran' => 'midtrans',
            ]));

            return;
        }

        if ($transactionStatus === 'pending') {
            $this->markPending($pembayaran, $commonData);

            return;
        }

        if ($transactionStatus === 'capture' && $fraudStatus === 'challenge') {
            $this->markChallenge($pembayaran, $commonData);

            return;
        }

        if (in_array($transactionStatus, ['deny', 'cancel', 'expire', 'failure'], true)) {
            $this->markFailed($pembayaran, $commonData, (string) $transactionStatus);

            return;
        }

        $pembayaran->update($commonData);
    }

    private function markPending(Pembayaran $pembayaran, array $commonData): void
    {
        $pembayaran->update(array_merge($commonData, [
            'status_pembayaran' => Pembayaran::STATUS_MENUNGGU_PEMBAYARAN,
            'catatan_admin' => null,
        ]));

        $pembayaran->pemesanan->update([
            'status_pemesanan' => Pemesanan::STATUS_MENUNGGU_PEMBAYARAN,
        ]);
    }

    private function markChallenge(Pembayaran $pembayaran, array $commonData): void
    {
        $pembayaran->update(array_merge($commonData, [
            'status_pembayaran' => Pembayaran::STATUS_MENUNGGU_VERIFIKASI,
            'catatan_admin' => 'Transaksi Midtrans masuk fraud challenge dan perlu pengecekan admin.',
        ]));

        $pembayaran->pemesanan->update([
            'status_pemesanan' => Pemesanan::STATUS_MENUNGGU_VERIFIKASI,
        ]);
    }

    private function markFailed(Pembayaran $pembayaran, array $commonData, string $transactionStatus): void
    {
        $pembayaran->update(array_merge($commonData, [
            'status_pembayaran' => Pembayaran::STATUS_DITOLAK,
            'catatan_admin' => 'Transaksi Midtrans '.$transactionStatus.'.',
            'verified_at' => null,
            'verified_by' => null,
        ]));

        $pembayaran->pemesanan->update([
            'status_pemesanan' => Pemesanan::STATUS_MENUNGGU_PEMBAYARAN,
        ]);
    }

    private function extractPaymentCode(array $payload): ?string
    {
        return $payload['payment_code']
            ?? data_get($payload, 'permata_va_number')
            ?? data_get($payload, 'bill_key');
    }

    private function extractVaNumber(array $payload): ?string
    {
        $vaNumbers = $payload['va_numbers'] ?? [];

        return is_array($vaNumbers) && isset($vaNumbers[0]['va_number'])
            ? $vaNumbers[0]['va_number']
            : null;
    }
}
