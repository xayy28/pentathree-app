<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Homestay extends Model
{
    use HasFactory, SoftDeletes;

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

    /**
     * Ulasan customer untuk homestay ini.
     */
    public function ulasans()
    {
        return $this->hasMany(Ulasan::class, 'homestay_id', 'homestay_id');
    }

    /**
     * Fasilitas yang tersedia di homestay ini.
     */
    public function fasilitas()
    {
        return $this->belongsToMany(
            Fasilitas::class,
            'homestay_fasilitas',
            'homestay_id',
            'fasilitas_id'
        );
    }
}
