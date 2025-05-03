@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Produk</h1>

    <form action="{{ route('produk.update', $produk->id_barang) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Nama Barang:</label>
        <input type="text" name="nama_barang" value="{{ $produk->nama_barang }}" required><br>

        <label>Stok:</label>
        <input type="number" name="stok" value="{{ $produk->stok }}" required><br>

        <label>Harga Beli:</label>
        <input type="number" name="harga_beli" value="{{ $produk->harga_beli }}" required><br>

        <label>Harga Jual:</label>
        <input type="number" name="harga_jual" value="{{ $produk->harga_jual }}" required><br>

        <label>Satuan:</label>
        <input type="text" name="satuan" value="{{ $produk->satuan }}" required><br><br>

        <button type="submit">Update</button>
    </form>
</div>
@endsection
