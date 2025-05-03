<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\DetailPenjualan;
use App\Models\Produk;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function index()
    {
        $produk = Produk::all();
        return view('transaksi', compact('produk'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $validated = $request->validate([
                'produk' => 'required|array',
                'produk.*.id' => 'required|exists:produk,id_barang',
                'produk.*.qtyPcs' => 'required|integer|min:0',
                'produk.*.qtyPaket' => 'required|integer|min:0',
                'produk.*.harga_jual' => 'required|numeric|min:0',
                'produk.*.harga_grosir' => 'nullable|numeric|min:0',
                'produk.*.isiPerPaket' => 'nullable|integer|min:1',
                'amount_paid' => 'required|numeric|min:0',
                'total_harga' => 'required|numeric|min:0'
            ]);

            $amountPaid = (float) $validated['amount_paid'];
            $grandTotal = 0;

            $penjualan = Penjualan::create([
                'tanggal' => now(),
                'total_harga' => 0, // sementara, diupdate setelah loop
                'amount_paid' => $amountPaid,
                'kembalian' => 0,
                'status' => 'belum lunas'
            ]);

            foreach ($validated['produk'] as $item) {
                $produk = Produk::findOrFail($item['id']);

                $qtyPcs = $item['qtyPcs'];
                $qtyPaket = $item['qtyPaket'];
                $isiPerPaket = $item['isiPerPaket'] ?? 0;
                $hargaJual = $item['harga_jual'];
                $hargaGrosir = $item['harga_grosir'] ?? 0;

                $jumlah = $qtyPcs + ($qtyPaket * $isiPerPaket);
                $totalHarga = ($qtyPcs * $hargaJual) + ($qtyPaket * $isiPerPaket * $hargaGrosir);

                $grandTotal += $totalHarga;
                $produk->decrement('stok', $jumlah);

                DetailPenjualan::create([
                    'id_jualan' => $penjualan->id_jualan,
                    'id_barang' => $produk->id_barang,
                    'jumlah' => $jumlah,
                    'harga_satuan' => 0, // campuran pcs + paket
                    'total_harga' => $totalHarga
                ]);
            }

            $penjualan->update([
                'total_harga' => $grandTotal,
                'kembalian' => max(0, $amountPaid - $grandTotal),
                'status' => ($amountPaid >= $grandTotal) ? 'lunas' : 'belum lunas'
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'data' => [
                    'id_jualan' => $penjualan->id_jualan,
                    'total_harga' => $grandTotal,
                    'amount_paid' => $amountPaid,
                    'status' => $penjualan->status,
                    'kembalian' => $penjualan->kembalian
                ]
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function show($id)
    {
        $penjualan = Penjualan::with('detailPenjualan.produk')->findOrFail($id);

        return response()->json([
            'total_harga' => $penjualan->total_harga,
            'amount_paid' => request()->query('amount_paid'),
            'kembalian' => request()->query('amount_paid') - $penjualan->total_harga,
            'details' => $penjualan->detailPenjualan->map(function ($item) {
                return [
                    'nama_barang' => $item->produk->nama_barang,
                    'jumlah' => $item->jumlah,
                    'total_harga' => $item->total_harga
                ];
            })
        ]);
    }

    public function showReceipt($id)
    {
        $transaksi = Penjualan::with(['detailPenjualan.produk'])->findOrFail($id);

        return view('struk', [
            'transaksi' => $transaksi
        ]);
    }
    public function riwayat(Request $request)
    {
        $tanggal = $request->query('tanggal', now()->toDateString());
    
        $transaksi = \App\Models\Penjualan::with('detailPenjualan.produk')
            ->whereDate('tanggal', $tanggal)
            ->orderBy('tanggal', 'desc')
            ->paginate(10);
    
        return view('riwayat', compact('transaksi'));
    }
    
    
}
