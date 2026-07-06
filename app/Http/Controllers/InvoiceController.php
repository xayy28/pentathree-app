<?php

namespace App\Http\Controllers;

use App\Models\Invoice;

class InvoiceController extends Controller
{
    public function showForUser($pemesanan_id)
    {
        $invoice = Invoice::with($this->invoiceRelations())
            ->whereHas('pemesanan', function ($query) use ($pemesanan_id) {
                $query->where('pemesanan_id', $pemesanan_id)
                    ->where('user_id', auth()->user()->user_id);
            })
            ->firstOrFail();

        return view('invoices.show', [
            'invoice' => $invoice,
            'backRoute' => route('user.pesanan.show', $invoice->pemesanan_id),
            'backLabel' => 'Kembali ke Detail Pesanan',
        ]);
    }

    public function showForAdmin($invoice_id)
    {
        $invoice = Invoice::with($this->invoiceRelations())->findOrFail($invoice_id);

        return view('invoices.show', [
            'invoice' => $invoice,
            'backRoute' => $this->adminBackRoute($invoice),
            'backLabel' => 'Kembali ke Modul Admin',
        ]);
    }

    private function invoiceRelations(): array
    {
        return [
            'pembayaran.verifier',
            'pemesanan.user',
            'pemesanan.pembayaran',
            'pemesanan.detailPemesanans.souvenir',
            'pemesanan.detailPemesanans.homestay',
        ];
    }

    private function adminBackRoute(Invoice $invoice): string
    {
        if ($invoice->pemesanan->jenis_pemesanan === 'homestay') {
            return route('admin.reservasi.show', $invoice->pemesanan_id);
        }

        return $invoice->pembayaran
            ? route('admin.pembayaran.show', $invoice->pembayaran->pembayaran_id)
            : route('admin.pembayaran');
    }
}
