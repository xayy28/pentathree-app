<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pemesanans', function (Blueprint $table) {
            $table->timestamp('admin_dilihat_pada')->nullable()->after('status_pemesanan');
        });

        DB::table('pemesanans')
            ->whereNull('admin_dilihat_pada')
            ->update(['admin_dilihat_pada' => now()]);
    }

    public function down(): void
    {
        Schema::table('pemesanans', function (Blueprint $table) {
            $table->dropColumn('admin_dilihat_pada');
        });
    }
};
