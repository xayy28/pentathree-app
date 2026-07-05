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
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id('pembayaran_id');
            $table->foreignId('pemesanan_id')->unique()->constrained('pemesanans', 'pemesanan_id')->onDelete('cascade');
            $table->string('metode_pembayaran', 50);
            $table->decimal('jumlah_bayar', 12, 2);
            $table->string('bukti_pembayaran')->nullable();
            $table->dateTime('tanggal_pembayaran');
            $table->string('status_pembayaran', 50)->default('menunggu_verifikasi');
            $table->text('catatan_admin')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->string('verified_by', 50)->nullable();
            $table->timestamps();

            $table->foreign('verified_by')->references('user_id')->on('users')->nullOnDelete();
            $table->index(['status_pembayaran', 'tanggal_pembayaran']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
