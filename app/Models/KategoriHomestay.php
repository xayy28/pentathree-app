<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KategoriHomestay extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'kategori_homestays';

    protected $primaryKey = 'kategori_id';

    protected $fillable = [
        'nama_kategori',
        'deskripsi',
    ];

    /**
     * Dapatkan semua homestay yang termasuk dalam kategori ini.
     */
    public function homestays()
    {
        return $this->hasMany(Homestay::class, 'kategori_id', 'kategori_id');
    }
}
