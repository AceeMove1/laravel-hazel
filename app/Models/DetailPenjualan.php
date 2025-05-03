<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPenjualan extends Model
{
    use HasFactory;

    protected $table = 'detail_penjualan';
    protected $primaryKey = 'id_detail';

    protected $fillable = [
        'id_jualan',
        'id_barang',
        'jumlah',
        'harga_satuan',
        'total_harga',
    ];

    // Relasi ke produk
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_barang', 'id_barang');
    }
    

    // Relasi ke penjualan
    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'id_jualan', 'id_jualan');
    }
}
