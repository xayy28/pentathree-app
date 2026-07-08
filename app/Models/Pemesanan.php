<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Pemesanan extends Model
{
    use HasFactory;

    public const JENIS_HOMESTAY = 'homestay';

    public const JENIS_SOUVENIR = 'souvenir';

    public const STATUS_DIBATALKAN = 'dibatalkan';

    public const STATUS_DIKONFIRMASI = 'dikonfirmasi';

    public const STATUS_DIPROSES = 'diproses';

    public const STATUS_KEDALUWARSA = 'kedaluwarsa';

    public const STATUS_MENUNGGU_PEMBAYARAN = 'menunggu_pembayaran';

    public const STATUS_MENUNGGU_VERIFIKASI = 'menunggu_verifikasi';

    public const STATUS_SEDANG_MENGINAP = 'sedang_menginap';

    public const STATUS_SELESAI = 'selesai';

    public const STATUS_SIAP_DIAMBIL_DIKIRIM = 'siap_diambil_dikirim';

    public const STATUS_TERVERIFIKASI = 'terverifikasi';

    protected $table = 'pemesanans';

    protected $primaryKey = 'pemesanan_id';

    protected $fillable = [
        'user_id',
        'kode_pemesanan',
        'jenis_pemesanan',
        'tanggal_pemesanan',
        'total_harga',
        'status_pemesanan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_pemesanan' => 'datetime',
            'total_harga' => 'decimal:2',
        ];
    }

    public static function homestayStatuses(): array
    {
        return [
            self::STATUS_MENUNGGU_PEMBAYARAN,
            self::STATUS_MENUNGGU_VERIFIKASI,
            self::STATUS_DIKONFIRMASI,
            self::STATUS_SEDANG_MENGINAP,
            self::STATUS_SELESAI,
            self::STATUS_DIBATALKAN,
            self::STATUS_KEDALUWARSA,
        ];
    }

    public static function homestayStatusLabels(): array
    {
        return [
            self::STATUS_MENUNGGU_PEMBAYARAN => 'Menunggu Pembayaran',
            self::STATUS_MENUNGGU_VERIFIKASI => 'Menunggu Verifikasi',
            self::STATUS_DIKONFIRMASI => 'Terverifikasi / Dikonfirmasi',
            self::STATUS_SEDANG_MENGINAP => 'Check-in / Sedang Menginap',
            self::STATUS_SELESAI => 'Selesai',
            self::STATUS_DIBATALKAN => 'Dibatalkan',
            self::STATUS_KEDALUWARSA => 'Kedaluwarsa',
            self::STATUS_DIPROSES => 'Diproses',
        ];
    }

    public static function souvenirStatuses(): array
    {
        return [
            self::STATUS_MENUNGGU_PEMBAYARAN,
            self::STATUS_MENUNGGU_VERIFIKASI,
            self::STATUS_TERVERIFIKASI,
            self::STATUS_DIPROSES,
            self::STATUS_SIAP_DIAMBIL_DIKIRIM,
            self::STATUS_SELESAI,
            self::STATUS_DIBATALKAN,
            self::STATUS_KEDALUWARSA,
        ];
    }

    public static function souvenirStatusLabels(): array
    {
        return [
            self::STATUS_MENUNGGU_PEMBAYARAN => 'Menunggu Pembayaran',
            self::STATUS_MENUNGGU_VERIFIKASI => 'Menunggu Verifikasi',
            self::STATUS_TERVERIFIKASI => 'Terverifikasi',
            self::STATUS_DIPROSES => 'Diproses / Dikemas',
            self::STATUS_SIAP_DIAMBIL_DIKIRIM => 'Siap Diambil / Dikirim',
            self::STATUS_SELESAI => 'Selesai',
            self::STATUS_DIBATALKAN => 'Dibatalkan',
            self::STATUS_KEDALUWARSA => 'Kedaluwarsa',
        ];
    }

    public static function statusLabels(): array
    {
        return array_merge(self::homestayStatusLabels(), self::souvenirStatusLabels());
    }

    public static function inactiveHomestayStatuses(): array
    {
        return [
            self::STATUS_DIBATALKAN,
            self::STATUS_KEDALUWARSA,
        ];
    }

    protected static function booted()
    {
        static::creating(function ($pemesanan) {
            if (empty($pemesanan->tanggal_pemesanan)) {
                $pemesanan->tanggal_pemesanan = now();
            }

            if (empty($pemesanan->kode_pemesanan)) {
                $tanggal = $pemesanan->tanggal_pemesanan instanceof \DateTimeInterface
                    ? $pemesanan->tanggal_pemesanan->format('Ymd')
                    : Carbon::parse($pemesanan->tanggal_pemesanan)->format('Ymd');
                $prefix = 'PMS-'.$tanggal.'-';
                $latestPemesanan = static::where('kode_pemesanan', 'like', $prefix.'%')
                    ->orderByDesc('kode_pemesanan')
                    ->first();
                $lastNumber = $latestPemesanan ? (int) substr($latestPemesanan->kode_pemesanan, -4) : 0;

                $pemesanan->kode_pemesanan = $prefix.str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
            }
        });
    }

    /**
     * User yang membuat pemesanan.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * Daftar item dalam pemesanan.
     */
    public function detailPemesanans()
    {
        return $this->hasMany(DetailPemesanan::class, 'pemesanan_id', 'pemesanan_id');
    }

    /**
     * Pembayaran untuk pemesanan ini.
     */
    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'pemesanan_id', 'pemesanan_id');
    }

    /**
     * Invoice yang diterbitkan setelah pembayaran valid.
     */
    public function invoice()
    {
        return $this->hasOne(Invoice::class, 'pemesanan_id', 'pemesanan_id');
    }

    /**
     * Ulasan yang dibuat untuk item dalam pemesanan ini.
     */
    public function ulasans()
    {
        return $this->hasMany(Ulasan::class, 'pemesanan_id', 'pemesanan_id');
    }
}
