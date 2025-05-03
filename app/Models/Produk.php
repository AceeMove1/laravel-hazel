<?php namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';
    protected $primaryKey = 'id_barang';

    protected $fillable = [
        'nama_barang',
        'stok',
        'harga_beli',
        'harga_jual',
        'satuan_dasar',
        'satuan_paket',
        'isi_per_paket',
        'harga_grosir',
    ];
    

    // Relasi ke detail_penjualan
    public function detailPenjualan()
    {
        return $this->hasMany(DetailPenjualan::class, 'id_barang', 'id_barang');
    }

    /**
     * Mengurangi stok produk.
     *
     * @param int $jumlah
     * @return bool
     */
    public function kurangiStok(int $jumlah): bool
    {
        // Pastikan stok cukup sebelum mengurangi
        if ($this->stok >= $jumlah) {
            $this->stok -= $jumlah; // Kurangi stok
            return $this->save();    // Simpan perubahan
        }

        // Jika stok tidak cukup, kembalikan false
        return false;
    }
}
