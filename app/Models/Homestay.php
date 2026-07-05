<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Homestay extends Model
{
    use HasFactory;

    protected $table = 'homestays';

    protected $primaryKey = 'homestay_id';

    protected $fillable = [
        'kategori_id',
        'nama_homestay',
        'harga_permalam',
        'kapasitas',
        'status',
        'detail',
        'foto',
    ];

    /**
     * Dapatkan kategori dari homestay ini.
     */
    public function kategori()
    {
        return $this->belongsTo(KategoriHomestay::class, 'kategori_id', 'kategori_id');
    }

    /**
     * Detail pemesanan yang berisi homestay ini.
     */
    public function detailPemesanans()
    {
        return $this->hasMany(DetailPemesanan::class, 'homestay_id', 'homestay_id');
    }
}
