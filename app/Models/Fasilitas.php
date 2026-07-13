<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fasilitas extends Model
{
    use HasFactory, SoftDeletes;

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
