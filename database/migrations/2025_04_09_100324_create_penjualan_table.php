<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenjualanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penjualan', function (Blueprint $table) {
    $table->id('id_jualan');
    $table->date('tanggal');
    $table->decimal('total_harga', 12, 2)->default(0);
    $table->decimal('amount_paid', 12, 2)->default(0);  // Kolom baru: uang yang dibayar customer
    $table->decimal('kembalian', 12, 2)->default(0);    // Kolom baru: uang kembalian
    $table->enum('status', ['lunas', 'belum lunas'])->default('belum lunas');
    $table->timestamps();
});

        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('penjualan');
    }
}
