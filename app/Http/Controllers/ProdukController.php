<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;

class ProdukController extends Controller
{
    public function index()
    {
        $produk = Produk::all();
        return view('produk.index', compact('produk'));
    }

    public function create()
    {
        return view('produk.create');
    }

    public function store(Request $request)
    {
        // Validasi input yang dikirim dari form
        $request->validate([
            'nama_barang'   => 'required|string|max:255',
            'stok'          => 'required|integer|min:0',
            'harga_beli'    => 'required|numeric|min:0',
            'harga_jual'    => 'required|numeric|min:0',
            'satuan_dasar'  => 'required|string|max:20',
            'satuan_paket'  => 'nullable|string|max:20',
            'isi_per_paket' => 'nullable|integer|min:1',
            'harga_grosir'  => 'nullable|numeric|min:0',
        ]);
    
        // Membuat produk baru dan menyimpannya ke dalam database
        Produk::create([
            'nama_barang'   => $request->nama_barang,
            'stok'          => $request->stok,
            'harga_beli'    => $request->harga_beli,
            'harga_jual'    => $request->harga_jual,
            'satuan_dasar'  => $request->satuan_dasar,
            'satuan_paket'  => $request->satuan_paket,
            'isi_per_paket' => $request->isi_per_paket,
            'harga_grosir'  => $request->harga_grosir,
        ]);
    
        // Redirect dengan pesan sukses setelah produk berhasil ditambahkan
        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan!');
    }
    

    public function show($id)
    {
        $produk = Produk::findOrFail($id);
        return view('produk.show', compact('produk'));
    }

    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        return view('produk.edit', compact('produk'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_barang'   => 'required|string|max:255',
            'stok'          => 'required|integer|min:0',
            'harga_beli'    => 'required|numeric|min:0',
            'harga_jual'    => 'required|numeric|min:0',
            'satuan_dasar'  => 'required|string|max:20',
            'satuan_paket'  => 'nullable|string|max:20',
            'isi_per_paket' => 'nullable|integer|min:1',
            'harga_grosir'  => 'nullable|numeric|min:0',
        ]);

        $produk = Produk::findOrFail($id);
        $produk->update($request->all());

        return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        $produk->delete();

        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus.');
    }
}
