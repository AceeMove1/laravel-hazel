<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdukTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produk', function (Blueprint $table) {
            $table->id('id_barang');
            $table->string('nama_barang', 100);
            $table->integer('stok')->default(0);
            $table->decimal('harga_beli', 12, 2);
            $table->decimal('harga_jual', 12, 2);
        
            // Tambahan revisi:
            $table->string('satuan_dasar', 20);               // Misal: pcs
            $table->string('satuan_paket', 20)->nullable();    // Misal: kotak
            $table->integer('isi_per_paket')->nullable();      // Misal: 12 (pcs per kotak)
            $table->decimal('harga_grosir', 12, 2)->nullable(); // Harga grosir per paket
        
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
        Schema::dropIfExists('produk');
    }
}
