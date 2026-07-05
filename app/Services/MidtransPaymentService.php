<?php

namespace App\Services;

use App\Models\Pembayaran;
use App\Models\Pemesanan;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction;
use RuntimeException;
use Throwable;

class MidtransPaymentService
{
    public function createSnapToken(Pemesanan $pemesanan, Pembayaran $pembayaran): string
    {
        $this->configure();

        try {
            return Snap::getSnapToken($this->snapPayload($pemesanan, $pembayaran));
        } catch (Throwable $exception) {
            throw new RuntimeException('Gagal membuat transaksi Midtrans: '.$exception->getMessage(), 0, $exception);
        }
    }

    public function checkTransactionStatus(Pembayaran $pembayaran): array
    {
        $this->configure();

        if (blank($pembayaran->midtrans_order_id)) {
            throw new RuntimeException('Midtrans Order ID belum tersedia.');
        }

        try {
            $status = Transaction::status($pembayaran->midtrans_order_id);
        } catch (Throwable $exception) {
            throw new RuntimeException('Gagal mengecek status Midtrans: '.$exception->getMessage(), 0, $exception);
        }

        return json_decode((string) json_encode($status), true) ?: [];
    }

    public function expectedSignature(array $payload): string
    {
        $serverKey = (string) config('midtrans.server_key');

        return hash(
            'sha512',
            ($payload['order_id'] ?? '').
            ($payload['status_code'] ?? '').
            ($payload['gross_amount'] ?? '').
            $serverKey
        );
    }

    public function verifySignature(array $payload): bool
    {
        if (blank(config('midtrans.server_key')) || blank($payload['signature_key'] ?? null)) {
            return false;
        }

        return hash_equals($this->expectedSignature($payload), (string) $payload['signature_key']);
    }

    private function configure(): void
    {
        $serverKey = (string) config('midtrans.server_key');
        $clientKey = (string) config('midtrans.client_key');
        $isProduction = (bool) config('midtrans.is_production');

        if (blank($serverKey) || blank($clientKey)) {
            throw new RuntimeException('Konfigurasi Midtrans Sandbox belum lengkap.');
        }

        if (! $this->hasValidKeyFormat($serverKey, 'server') || ! $this->hasValidKeyFormat($clientKey, 'client')) {
            throw new RuntimeException('Format Server Key atau Client Key Midtrans tidak valid. Copy key persis dari menu Access Keys Midtrans.');
        }

        if ($isProduction && (str_starts_with($serverKey, 'SB-Mid-server-') || str_starts_with($clientKey, 'SB-Mid-client-'))) {
            throw new RuntimeException('Mode Midtrans Production tidak boleh memakai key Sandbox.');
        }

        Config::$serverKey = $serverKey;
        Config::$isProduction = $isProduction;
        Config::$isSanitized = (bool) config('midtrans.is_sanitized');
        Config::$is3ds = (bool) config('midtrans.is_3ds');
    }

    private function hasValidKeyFormat(string $key, string $type): bool
    {
        return str_starts_with($key, "Mid-{$type}-")
            || str_starts_with($key, "SB-Mid-{$type}-");
    }

    private function snapPayload(Pemesanan $pemesanan, Pembayaran $pembayaran): array
    {
        $details = $pemesanan->detailPemesanans;
        $itemDetails = $details->map(function ($detail) {
            return [
                'id' => (string) $detail->detail_pemesanan_id,
                'price' => (int) round((float) $detail->harga),
                'quantity' => (int) $detail->jumlah,
                'name' => Str::limit($detail->nama_item, 45, ''),
            ];
        })->values()->all();

        $itemsTotal = collect($itemDetails)->sum(fn ($item) => $item['price'] * $item['quantity']);
        $grossAmount = (int) round((float) $pemesanan->total_harga);
        $remainingAmount = $grossAmount - $itemsTotal;

        if ($remainingAmount > 0) {
            $itemDetails[] = [
                'id' => 'fee-'.$pemesanan->pemesanan_id,
                'price' => $remainingAmount,
                'quantity' => 1,
                'name' => 'Biaya layanan',
            ];
        }

        return [
            'transaction_details' => [
                'order_id' => $pembayaran->midtrans_order_id,
                'gross_amount' => $grossAmount,
            ],
            'customer_details' => [
                'first_name' => $pemesanan->user->nama,
                'email' => $pemesanan->user->email,
                'phone' => $pemesanan->user->no_hp,
            ],
            'item_details' => $itemDetails,
        ];
    }
}
