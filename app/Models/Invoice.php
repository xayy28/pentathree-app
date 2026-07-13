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

                $existingNumbers = static::where('nomor_invoice', 'like', $prefix.'%')
                    ->pluck('nomor_invoice')
                    ->map(function ($inv) {
                        $lastDash = strrpos($inv, '-');
                        $lastSegment = $lastDash !== false ? substr($inv, $lastDash + 1) : $inv;

                        return (int) preg_replace('/[^0-9]/', '', $lastSegment);
                    })
                    ->filter()
                    ->values();

                $lastNumber = $existingNumbers->isEmpty() ? 0 : $existingNumbers->max();

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
