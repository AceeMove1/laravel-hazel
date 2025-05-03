<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\DetailPenjualan;
use App\Models\Produk;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $range = (int) $request->query('range', 7);
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        if ($startDate && $endDate) {
            $tanggalMulai = \Carbon\Carbon::parse($startDate)->startOfDay();
            $tanggalAkhir = \Carbon\Carbon::parse($endDate)->endOfDay();
        } else {
            $tanggalMulai = now()->subDays($range - 1)->toDateString();
            $tanggalAkhir = now()->toDateString();
        }

        // Grafik Omset
        $omset = Penjualan::whereBetween('tanggal', [$tanggalMulai, $tanggalAkhir])
            ->select(DB::raw('DATE(tanggal) as tanggal'), DB::raw('SUM(total_harga) as total'))
            ->groupBy(DB::raw('DATE(tanggal)'))
            ->orderBy('tanggal')
            ->get();

        // Produk Terjual
        $produkTerjual = DetailPenjualan::with('produk')
        ->whereHas('penjualan', function ($query) use ($tanggalMulai, $tanggalAkhir) {
            $query->whereBetween('tanggal', [$tanggalMulai, $tanggalAkhir]);
        })
        ->get()
        ->filter(fn($item) => $item->produk) // pastikan produk tidak null
        ->groupBy(fn($item) => strtolower($item->produk->nama_barang))
        ->map(function ($items) {
            $produk = $items->first()->produk;
            return (object)[
                'nama_barang' => $produk->nama_barang,
                'total_terjual' => $items->sum('jumlah'),
            ];
        })
        
        ->sortByDesc('total_terjual')
        ->values(); // buang key-nya biar gampang dipakai di Blade

        // Hitung margin per produk
        foreach ($produkTerjual as $item) {
            $hargaBeli = $item->produk->harga_beli ?? 0;
            $hargaJual = $item->produk->harga_jual ?? 0;
            $item->margin = $hargaBeli > 0 ? round((($hargaJual - $hargaBeli) / $hargaBeli) * 100, 2) : 0;
        }

        // Total Laba Bersih
        $labaBersih = DetailPenjualan::with('produk')
            ->whereHas('penjualan', function ($query) use ($tanggalMulai, $tanggalAkhir) {
                $query->whereBetween('tanggal', [$tanggalMulai, $tanggalAkhir]);
            })
            ->get()
            ->sum(function ($item) {
                $hargaBeli = $item->produk->harga_beli ?? 0;
                $hargaJualPerItem = $item->total_harga / max($item->jumlah, 1);
                $labaPerItem = $hargaJualPerItem - $hargaBeli;
                return $labaPerItem * $item->jumlah;
            });

        // Laba Bersih Per Hari (untuk grafik)
        $labaBersihPerHari = DetailPenjualan::with('produk', 'penjualan')
            ->whereHas('penjualan', function ($q) use ($tanggalMulai, $tanggalAkhir) {
                $q->whereBetween('tanggal', [$tanggalMulai, $tanggalAkhir]);
            })
            ->get()
            ->groupBy(fn($item) => \Carbon\Carbon::parse($item->penjualan->tanggal)->toDateString())
            ->map(function ($group) {
                return $group->sum(function ($item) {
                    $modal = $item->produk->harga_beli ?? 0;
                    $jual = $item->total_harga;
                    return $jual - ($modal * $item->jumlah);
                });
            });

        // Barang tidak laku
        $produkTidakLaku = Produk::whereDoesntHave('detailPenjualan.penjualan', function ($q) use ($tanggalMulai, $tanggalAkhir) {
            $q->whereBetween('tanggal', [$tanggalMulai, $tanggalAkhir]);
        })->get();

        // Barang perlu restok
        $barangRestok = Produk::where('stok', '<=', 10)->get();

        return view('laporan', [
            'omset' => $omset,
            'produkTerjual' => $produkTerjual,
            'barangRestok' => $barangRestok,
            'produkTidakLaku' => $produkTidakLaku,
            'labaBersihPerHari' => $labaBersihPerHari,
            'labaBersih' => $labaBersih,
            'range' => $range,
        ]);
    }

    public function exportPdf(Request $request)
    {
        $range = (int) $request->query('range', 7);
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        $tanggalMulai = $startDate ?? now()->subDays($range - 1)->toDateString();
        $tanggalAkhir = $endDate ?? now()->toDateString();

        // Ambil data seperti di index
        $produkTerjual = DetailPenjualan::with('produk')
        ->whereHas('penjualan', function ($query) use ($tanggalMulai, $tanggalAkhir) {
            $query->whereBetween('tanggal', [$tanggalMulai, $tanggalAkhir]);
        })
        ->get()
        ->filter(fn($item) => $item->produk)
        ->groupBy(fn($item) => strtolower($item->produk->nama_barang)) // <- ini penting
        ->map(function ($items) {
            $produk = $items->first()->produk;
            return (object)[
                'nama_barang' => $produk->nama_barang,
                'total_terjual' => $items->sum('jumlah'),
            ];
        })
        ->sortByDesc('total_terjual')
        ->values();
    

        $barangRestok = Produk::where('stok', '<=', 10)->get();

        $produkTidakLaku = Produk::whereDoesntHave('detailPenjualan.penjualan', function ($q) use ($tanggalMulai, $tanggalAkhir) {
            $q->whereBetween('tanggal', [$tanggalMulai, $tanggalAkhir]);
        })->get();

        $omset = Penjualan::whereBetween('tanggal', [$tanggalMulai, $tanggalAkhir])
            ->sum('total_harga');

        $labaBersih = DetailPenjualan::with('produk')
            ->whereHas('penjualan', function ($query) use ($tanggalMulai, $tanggalAkhir) {
                $query->whereBetween('tanggal', [$tanggalMulai, $tanggalAkhir]);
            })
            ->get()
            ->sum(function ($item) {
                $beli = $item->produk->harga_beli ?? 0;
                $jual = $item->total_harga / max($item->jumlah, 1);
                return ($jual - $beli) * $item->jumlah;
            });

        $pdf = Pdf::loadView('laporan_pdf', compact(
            'produkTerjual',
            'barangRestok',
            'produkTidakLaku',
            'omset',
            'labaBersih',
            'tanggalMulai',
            'tanggalAkhir'
        ));

        return $pdf->download('laporan_penjualan_' . now()->format('Ymd_His') . '.pdf');
    }
}
