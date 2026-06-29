<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    public const STATUS_DITOLAK = 'ditolak';

    public const STATUS_MENUNGGU_VERIFIKASI = 'menunggu_verifikasi';

    public const STATUS_TERVERIFIKASI = 'terverifikasi';

    protected $table = 'pembayarans';

    protected $primaryKey = 'pembayaran_id';

    protected $fillable = [
        'pemesanan_id',
        'metode_pembayaran',
        'jumlah_bayar',
        'bukti_pembayaran',
        'tanggal_pembayaran',
        'status_pembayaran',
        'catatan_admin',
        'verified_at',
        'verified_by',
    ];

    protected function casts(): array
    {
        return [
            'jumlah_bayar' => 'decimal:2',
            'tanggal_pembayaran' => 'datetime',
            'verified_at' => 'datetime',
        ];
    }

    /**
     * Pemesanan yang dibayar.
     */
    public function pemesanan()
    {
        return $this->belongsTo(Pemesanan::class, 'pemesanan_id', 'pemesanan_id');
    }

    /**
     * Admin yang memverifikasi pembayaran.
     */
    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by', 'user_id');
    }
}
