<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    use HasFactory;

    protected $table = 'keranjang';

    protected $fillable = [
        'user_id',
    ];

    /**
     * Hubungan ke model User (Cart belongsTo User).
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * Hubungan ke model KeranjangItem (Cart hasMany CartItem).
     */
    public function keranjangItems()
    {
        return $this->hasMany(KeranjangItem::class, 'id_keranjang', 'id');
    }
}
