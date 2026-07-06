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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id('invoice_id');
            $table->foreignId('pemesanan_id')->unique()->constrained('pemesanans', 'pemesanan_id')->onDelete('cascade');
            $table->foreignId('pembayaran_id')->nullable()->unique()->constrained('pembayarans', 'pembayaran_id')->nullOnDelete();
            $table->string('nomor_invoice', 40)->unique();
            $table->dateTime('tanggal_invoice');
            $table->decimal('total_tagihan', 12, 2);
            $table->string('status_invoice', 50)->default('terbit');
            $table->timestamps();

            $table->index(['tanggal_invoice', 'status_invoice']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
