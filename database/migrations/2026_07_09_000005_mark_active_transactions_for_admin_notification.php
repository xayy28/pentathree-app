<?php

use App\Models\Pembayaran;
use App\Models\Pemesanan;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('pemesanans', 'admin_dilihat_pada')) {
            return;
        }

        DB::table('pemesanans')
            ->whereIn('status_pemesanan', [
                Pemesanan::STATUS_MENUNGGU_PEMBAYARAN,
                Pemesanan::STATUS_MENUNGGU_VERIFIKASI,
            ])
            ->update(['admin_dilihat_pada' => null]);

        DB::table('pemesanans')
            ->whereIn('pemesanan_id', function ($query) {
                $query->select('pemesanan_id')
                    ->from('pembayarans')
                    ->where('status_pembayaran', Pembayaran::STATUS_MENUNGGU_VERIFIKASI);
            })
            ->update(['admin_dilihat_pada' => null]);
    }

    public function down(): void
    {
        //
    }
};
