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
        Schema::create('keranjang_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_keranjang');
            $table->unsignedBigInteger('souvenir_id');
            $table->integer('quantity')->default(1);
            $table->timestamps();

            $table->foreign('id_keranjang')->references('id')->on('keranjang')->onDelete('cascade');
            $table->foreign('souvenir_id')->references('souvenir_id')->on('souvenirs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keranjang_items');
    }
};
