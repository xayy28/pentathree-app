<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Souvenir extends Model
{
    use HasFactory;

    protected $table = 'souvenirs';

    protected $primaryKey = 'souvenir_id';

    protected $fillable = [
        'nama_souvenir',
        'harga',
        'stok',
        'status',
        'detail',
        'foto',
        'jumlah_terjual', // Dikelola otomatis oleh sistem dari transaksi pembelian
        'updated_by',
    ];

    /**
     * Hubungan ke Admin yang memperbarui data souvenir.
     */
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by', 'user_id');
    }
}
