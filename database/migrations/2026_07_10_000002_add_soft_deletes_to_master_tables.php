<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('homestays', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('souvenirs', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('kategori_homestays', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('fasilitas', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::table('homestays', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('souvenirs', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('kategori_homestays', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('fasilitas', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
