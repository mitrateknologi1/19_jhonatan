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
        Schema::create('mape', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('produk_id');
            $table->foreign('produk_id')->references('id')->on('produk');

            $table->unsignedSmallInteger('bulan');
            $table->unsignedSmallInteger('tahun');

            $table->unsignedSmallInteger('aktual');
            $table->unsignedSmallInteger('forcast');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mape', function (Blueprint $table) {
            $table->dropForeign(['produk_id']);
        });

        Schema::dropIfExists('mape');
    }
};
