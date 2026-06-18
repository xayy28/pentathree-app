<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeranjangItem extends Model
{
    use HasFactory;

    protected $table = 'keranjang_items';

    protected $fillable = [
        'id_keranjang',
        'souvenir_id',
        'quantity',
    ];

    /**
     * Hubungan ke model Keranjang (CartItem belongsTo Cart).
     */
    public function keranjang()
    {
        return $this->belongsTo(Keranjang::class, 'id_keranjang', 'id');
    }

    /**
     * Hubungan ke model Souvenir (CartItem belongsTo Souvenir).
     */
    public function souvenir()
    {
        return $this->belongsTo(Souvenir::class, 'souvenir_id', 'souvenir_id');
    }
}
