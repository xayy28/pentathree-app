<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('homestay_fasilitas', function (Blueprint $table) {
            $table->unsignedBigInteger('homestay_id');
            $table->unsignedBigInteger('fasilitas_id');

            $table->primary(['homestay_id', 'fasilitas_id']);

            $table->foreign('homestay_id')
                ->references('homestay_id')
                ->on('homestays')
                ->cascadeOnDelete();

            $table->foreign('fasilitas_id')
                ->references('fasilitas_id')
                ->on('fasilitas')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('homestay_fasilitas');
    }
};
