<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Penjualan;
use App\Models\DetailPenjualan;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $range = $request->query('range', '7'); // default 7 hari
        $days = in_array($range, ['7', '30']) ? (int) $range : 7;

        // Total Produk
        $totalProduk = Produk::count();

        // Total Stok (dari semua produk)
        $totalStok = Produk::sum('stok');

        // Omset Hari Ini
        $today = now()->toDateString();
        $omsetHariIni = Penjualan::whereDate('tanggal', $today)->sum('total_harga');

        // Jumlah Transaksi Hari Ini
        $jumlahTransaksi = Penjualan::whereDate('tanggal', $today)->count();

        // Barang Terlaris Hari Ini (5 teratas)
        $barangTerlaris = DetailPenjualan::select('id_barang', DB::raw('SUM(jumlah) as total_terjual'))
                            ->whereHas('penjualan', function ($query) use ($today) {
                                $query->whereDate('tanggal', $today);
                            })
                            ->groupBy('id_barang')
                            ->orderByDesc('total_terjual')
                            ->with('produk')
                            ->limit(5)
                            ->get();

      // Total Laba Bersih Hari Ini
$labaBersih = DetailPenjualan::with('produk')
->whereHas('penjualan', function ($query) use ($today) {
    $query->whereDate('tanggal', $today);
})
->get()
->sum(function ($item) {
    $hargaBeli = $item->produk->harga_beli ?? 0;
    $hargaJualPerItem = $item->total_harga / max($item->jumlah, 1);
    $labaPerItem = $hargaJualPerItem - $hargaBeli;
    return $labaPerItem * $item->jumlah;
});

    $transaksiTerakhir = Penjualan::whereDate('tanggal', now())
    ->latest('tanggal')
    ->take(10)
    ->get();


        // Data untuk grafik penjualan berdasarkan rentang waktu
        $penjualan7Hari = Penjualan::select(
                                DB::raw('DATE(tanggal) as tanggal'),
                                DB::raw('SUM(total_harga) as total')
                            )
                            ->where('tanggal', '>=', now()->subDays($days - 1)->startOfDay())
                            ->groupBy(DB::raw('DATE(tanggal)'))
                            ->orderBy('tanggal')
                            ->get();

                            return view('dashboard', [
                                'totalProduk' => $totalProduk,
                                'totalStok' => $totalStok,
                                'omsetHariIni' => $omsetHariIni,
                                'jumlahTransaksi' => $jumlahTransaksi,
                                'barangTerlaris' => $barangTerlaris,
                                'penjualan7Hari' => $penjualan7Hari,
                                'labaBersih' => $labaBersih,
                                'range' => $days,
                                'transaksiTerakhir' => $transaksiTerakhir,

                            ]);
    }
    
}
