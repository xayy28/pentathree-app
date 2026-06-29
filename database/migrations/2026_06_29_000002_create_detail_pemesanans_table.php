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
        Schema::create('detail_pemesanans', function (Blueprint $table) {
            $table->id('detail_pemesanan_id');
            $table->foreignId('pemesanan_id')->constrained('pemesanans', 'pemesanan_id')->onDelete('cascade');
            $table->foreignId('homestay_id')->nullable()->constrained('homestays', 'homestay_id')->nullOnDelete();
            $table->foreignId('souvenir_id')->nullable()->constrained('souvenirs', 'souvenir_id')->nullOnDelete();
            $table->string('nama_item');
            $table->decimal('harga', 12, 2);
            $table->unsignedInteger('jumlah')->default(1);
            $table->date('check_in')->nullable();
            $table->date('check_out')->nullable();
            $table->unsignedInteger('jumlah_malam')->nullable();
            $table->decimal('subtotal', 12, 2);
            $table->timestamps();

            $table->index(['pemesanan_id', 'homestay_id', 'souvenir_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_pemesanans');
    }
};
