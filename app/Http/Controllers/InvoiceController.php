<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    /**
     * Tampilkan invoice untuk pelanggan.
     */
    public function showForUser($pemesanan_id)
    {
        $invoice = $this->findUserInvoiceOrFail($pemesanan_id);

        return view('invoices.show', [
            'invoice' => $invoice,
            'backRoute' => route('user.pesanan.show', $invoice->pemesanan_id),
            'backLabel' => 'Kembali ke Detail Pesanan',
        ]);
    }

    /**
     * Unduh invoice sebagai PDF untuk pelanggan.
     */
    public function downloadPdfForUser($pemesanan_id)
    {
        $invoice = $this->findUserInvoiceOrFail($pemesanan_id);

        return $this->buildPdf($invoice)
            ->stream($this->pdfFilename($invoice));
    }

    /**
     * Tampilkan invoice untuk admin.
     */
    public function showForAdmin($invoice_id)
    {
        $invoice = Invoice::with($this->invoiceRelations())->findOrFail($invoice_id);

        return view('invoices.show', [
            'invoice' => $invoice,
            'backRoute' => $this->adminBackRoute($invoice),
            'backLabel' => 'Kembali ke Modul Admin',
        ]);
    }

    /**
     * Unduh invoice sebagai PDF untuk admin.
     */
    public function downloadPdfForAdmin($invoice_id)
    {
        $invoice = Invoice::with($this->invoiceRelations())->findOrFail($invoice_id);

        return $this->buildPdf($invoice)
            ->stream($this->pdfFilename($invoice));
    }

    // ──────────────────────────────────────────────
    // Private helpers
    // ──────────────────────────────────────────────

    private function findUserInvoiceOrFail($pemesanan_id): Invoice
    {
        return Invoice::with($this->invoiceRelations())
            ->whereHas('pemesanan', function ($query) use ($pemesanan_id) {
                $query->where('pemesanan_id', $pemesanan_id)
                    ->where('user_id', auth()->user()->user_id);
            })
            ->firstOrFail();
    }

    private function buildPdf(Invoice $invoice): \Barryvdh\DomPDF\PDF
    {
        $pdf = Pdf::loadView('invoices.pdf', ['invoice' => $invoice])
            ->setPaper('a4', 'portrait');

        return $pdf;
    }

    private function pdfFilename(Invoice $invoice): string
    {
        return $invoice->nomor_invoice.'.pdf';
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
