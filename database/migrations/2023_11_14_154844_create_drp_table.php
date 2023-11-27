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
        Schema::create('drp', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('customer');

            $table->unsignedBigInteger('produk_id');
            $table->foreign('produk_id')->references('id')->on('produk');

            $table->unsignedSmallInteger('bulan');
            $table->unsignedSmallInteger('tahun');

            $table->unsignedSmallInteger('gross_requirement')->nullable();
            $table->unsignedSmallInteger('projected_on_hand')->nullable();
            $table->unsignedSmallInteger('net_requirement')->nullable();
            $table->unsignedSmallInteger('plan_order_receipt')->nullable();
            $table->unsignedSmallInteger('plan_order_release')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('drp', function (Blueprint $table) {
            $table->dropForeign(['customer_id']);
            $table->dropForeign(['produk_id']);
        });

        Schema::dropIfExists('drp');
    }
};
