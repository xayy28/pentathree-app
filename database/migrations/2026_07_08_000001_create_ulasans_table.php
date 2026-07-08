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
        Schema::create('ulasans', function (Blueprint $table) {
            $table->id('ulasan_id');
            $table->string('user_id', 50);
            $table->foreignId('pemesanan_id')->constrained('pemesanans', 'pemesanan_id')->cascadeOnDelete();
            $table->foreignId('detail_pemesanan_id')->constrained('detail_pemesanans', 'detail_pemesanan_id')->cascadeOnDelete();
            $table->foreignId('homestay_id')->nullable()->constrained('homestays', 'homestay_id')->nullOnDelete();
            $table->foreignId('souvenir_id')->nullable()->constrained('souvenirs', 'souvenir_id')->nullOnDelete();
            $table->unsignedTinyInteger('rating');
            $table->text('komentar')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('user_id')->on('users')->cascadeOnDelete();
            $table->unique('detail_pemesanan_id');
            $table->index(['homestay_id', 'rating']);
            $table->index(['souvenir_id', 'rating']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ulasans');
    }
};
