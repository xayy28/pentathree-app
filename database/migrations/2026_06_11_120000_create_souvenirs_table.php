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
        Schema::create('souvenirs', function (Blueprint $table) {
            $table->id('souvenir_id');
            $table->string('nama_souvenir');
            $table->decimal('harga', 10, 2);
            $table->integer('stok');
            $table->string('status');
            $table->text('detail')->nullable();
            $table->string('foto')->nullable();
            $table->unsignedInteger('jumlah_terjual')->default(0)->comment('Dikelola otomatis oleh sistem dari transaksi pembelian');
            $table->string('updated_by', 50)->nullable();
            $table->foreign('updated_by')->references('user_id')->on('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('souvenirs');
    }
};
