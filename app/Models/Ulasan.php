<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ulasan extends Model
{
    use HasFactory;

    protected $table = 'ulasans';

    protected $primaryKey = 'ulasan_id';

    protected $fillable = [
        'user_id',
        'pemesanan_id',
        'detail_pemesanan_id',
        'homestay_id',
        'souvenir_id',
        'rating',
        'komentar',
    ];

    protected function casts(): array
    {
        return [
            'rating' => 'integer',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function pemesanan()
    {
        return $this->belongsTo(Pemesanan::class, 'pemesanan_id', 'pemesanan_id');
    }

    public function detailPemesanan()
    {
        return $this->belongsTo(DetailPemesanan::class, 'detail_pemesanan_id', 'detail_pemesanan_id');
    }

    public function homestay()
    {
        return $this->belongsTo(Homestay::class, 'homestay_id', 'homestay_id');
    }

    public function souvenir()
    {
        return $this->belongsTo(Souvenir::class, 'souvenir_id', 'souvenir_id');
    }
}
