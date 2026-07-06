<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Invoice extends Model
{
    use HasFactory;

    public const STATUS_TERBIT = 'terbit';

    protected $table = 'invoices';

    protected $primaryKey = 'invoice_id';

    protected $fillable = [
        'pemesanan_id',
        'pembayaran_id',
        'nomor_invoice',
        'tanggal_invoice',
        'total_tagihan',
        'status_invoice',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_invoice' => 'datetime',
            'total_tagihan' => 'decimal:2',
        ];
    }

    protected static function booted()
    {
        static::creating(function ($invoice) {
            if (empty($invoice->tanggal_invoice)) {
                $invoice->tanggal_invoice = now();
            }

            if (empty($invoice->nomor_invoice)) {
                $tanggal = $invoice->tanggal_invoice instanceof \DateTimeInterface
                    ? $invoice->tanggal_invoice->format('Ymd')
                    : Carbon::parse($invoice->tanggal_invoice)->format('Ymd');
                $prefix = 'INV-'.$tanggal.'-';
                $latestInvoice = static::where('nomor_invoice', 'like', $prefix.'%')
                    ->orderByDesc('nomor_invoice')
                    ->first();
                $lastNumber = $latestInvoice ? (int) substr($latestInvoice->nomor_invoice, -4) : 0;

                $invoice->nomor_invoice = $prefix.str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
            }
        });
    }

    public function pemesanan()
    {
        return $this->belongsTo(Pemesanan::class, 'pemesanan_id', 'pemesanan_id');
    }

    public function pembayaran()
    {
        return $this->belongsTo(Pembayaran::class, 'pembayaran_id', 'pembayaran_id');
    }
}
