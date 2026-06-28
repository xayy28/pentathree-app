<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPemesanan extends Model
{
    use HasFactory;

    protected $table = 'detail_pemesanans';

    protected $primaryKey = 'detail_pemesanan_id';

    protected $fillable = [
        'pemesanan_id',
        'homestay_id',
        'souvenir_id',
        'nama_item',
        'harga',
        'jumlah',
        'check_in',
        'check_out',
        'jumlah_malam',
        'subtotal',
    ];

    protected function casts(): array
    {
        return [
            'harga' => 'decimal:2',
            'subtotal' => 'decimal:2',
            'check_in' => 'date',
            'check_out' => 'date',
        ];
    }

    /**
     * Induk pemesanan.
     */
    public function pemesanan()
    {
        return $this->belongsTo(Pemesanan::class, 'pemesanan_id', 'pemesanan_id');
    }

    /**
     * Homestay yang dipesan, jika detail ini untuk reservasi homestay.
     */
    public function homestay()
    {
        return $this->belongsTo(Homestay::class, 'homestay_id', 'homestay_id');
    }

    /**
     * Souvenir yang dipesan, jika detail ini untuk pembelian souvenir.
     */
    public function souvenir()
    {
        return $this->belongsTo(Souvenir::class, 'souvenir_id', 'souvenir_id');
    }
}
