<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pemesanans', function (Blueprint $table) {
            $table->id('pemesanan_id');
            $table->string('user_id', 50);
            $table->string('kode_pemesanan', 32)->unique();
            $table->enum('jenis_pemesanan', ['souvenir', 'homestay']);
            $table->dateTime('tanggal_pemesanan');
            $table->decimal('total_harga', 12, 2)->default(0);
            $table->string('status_pemesanan', 50)->default('menunggu_pembayaran');
            $table->timestamps();

            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->index(['user_id', 'jenis_pemesanan', 'status_pemesanan']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemesanans');
    }
};
