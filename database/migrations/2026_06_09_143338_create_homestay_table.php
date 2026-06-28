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
        Schema::create('homestays', function (Blueprint $table) {
            $table->id('homestay_id');
            $table->foreignId('kategori_id')->nullable()->constrained('kategori_homestays', 'kategori_id')->onDelete('set null');
            $table->string('nama_homestay');
            $table->decimal('harga_permalam', 10, 2);
            $table->integer('kapasitas');
            $table->string('status');
            $table->string('detail')->nullable();
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('homestays');
    }
};
