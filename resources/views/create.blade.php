@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tambah Produk</h1>

    <form action="{{ route('produk.store') }}" method="POST">
        @csrf
        <label>Nama Barang:</label>
        <input type="text" name="nama_barang" required><br>

        <label>Stok:</label>
        <input type="number" name="stok" required><br>

        <label>Harga Beli:</label>
        <input type="number" name="harga_beli" required><br>

        <label>Harga Jual:</label>
        <input type="number" name="harga_jual" required><br>

        <label>Satuan:</label>
        <input type="text" name="satuan" required><br><br>

        <button type="submit">Simpan</button>
    </form>
</div>
@endsection
