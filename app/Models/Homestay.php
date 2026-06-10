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
        'nama_homestay',
        'harga_permalam',
        'kapasitas',
        'status',
        'detail',
        'foto',
    ];
}
