<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;

    protected $table = 'penjualan';
    protected $primaryKey = 'id_jualan';

    protected $fillable = [
        'tanggal',
        'total_harga',
        'amount_paid',
        'kembalian',
        'status'
    ];
    
    // Otomatis cast kolom tanggal ke objek Carbon
    protected $casts = [
        'tanggal' => 'datetime',
    ];
    

    // Relasi ke detail penjualan
    public function detailPenjualan()
    {
        return $this->hasMany(DetailPenjualan::class, 'id_jualan', 'id_jualan');
    }
}
