<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fasilitas extends Model
{
    use HasFactory;

    protected $table = 'fasilitas';

    protected $primaryKey = 'fasilitas_id';

    protected $fillable = [
        'nama_fasilitas',
        'ikon',
    ];

    /**
     * Homestay yang memiliki fasilitas ini.
     */
    public function homestays()
    {
        return $this->belongsToMany(
            Homestay::class,
            'homestay_fasilitas',
            'fasilitas_id',
            'homestay_id'
        );
    }
}
