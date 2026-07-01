<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Services\MidtransPaymentService;
use App\Services\MidtransPaymentStatusService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use RuntimeException;

class MidtransWebhookController extends Controller
{
    public function handle(
        Request $request,
        MidtransPaymentService $midtransPaymentService,
        MidtransPaymentStatusService $midtransPaymentStatusService
    ): JsonResponse {
        $payload = $request->all();

        if (! $midtransPaymentService->verifySignature($payload)) {
            return response()->json([
                'message' => 'Invalid Midtrans signature.',
            ], 403);
        }

        $pembayaran = Pembayaran::with('pemesanan.detailPemesanans.souvenir')
            ->where('midtrans_order_id', $payload['order_id'] ?? null)
            ->firstOrFail();

        try {
            $midtransPaymentStatusService->apply($pembayaran, $payload);
        } catch (RuntimeException $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
            ], 422);
        }

        return response()->json([
            'message' => 'Midtrans notification handled.',
        ]);
    }
}
