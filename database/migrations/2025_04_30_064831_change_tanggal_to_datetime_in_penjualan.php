<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeTanggalToDatetimeInPenjualan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('penjualan', function (Blueprint $table) {
            $table->dateTime('tanggal')->change();
        });
    }
    
    public function down()
    {
        Schema::table('penjualan', function (Blueprint $table) {
            $table->date('tanggal')->change();
        });
    }
    
}
