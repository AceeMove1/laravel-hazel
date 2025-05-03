<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    // Menentukan nama tabel
    protected $table = 'penjualan'; // Pastikan nama tabel sesuai dengan tabel di database

    // Jika Anda ingin menonaktifkan timestamp, tambahkan properti berikut
    // public $timestamps = false;

    // Definisikan relasi ke DetailTransaksi
    public function details()
    {
        return $this->hasMany(DetailPenjualan::class, 'id_detail'); // Sesuaikan dengan nama kolom foreign key di tabel details
    }

    // Menambahkan kolom yang bisa diisi secara mass-assignment
    protected $fillable = [
        'column1', 'column2', // Ganti dengan nama kolom yang sesuai
    ];

    // Jika Anda memiliki kolom 'created_at' dan 'updated_at', tidak perlu menambah properti apapun
}
