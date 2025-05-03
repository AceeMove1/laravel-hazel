<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan - Hazel ATK</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 13px;
            color: #333;
        }
        h2, h4 {
            margin: 0;
            padding: 0;
        }
        .header, .section {
            margin-bottom: 20px;
        }
        .summary {
            margin-top: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            margin-bottom: 25px;
        }
        th, td {
            border: 1px solid #777;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #eee;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Hazel ATK</h2>
        <h4>Laporan Penjualan</h4>
        <p>Periode: {{ \Carbon\Carbon::parse($tanggalMulai)->translatedFormat('d M Y') }} - {{ \Carbon\Carbon::parse($tanggalAkhir)->translatedFormat('d M Y') }}</p>
    </div>

    <div class="summary">
        <table>
            <tr>
                <th>Total Omset</th>
                <td>Rp{{ number_format($omset, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <th>Total Laba Bersih</th>
                <td>Rp{{ number_format($labaBersih, 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <h4>Produk Terjual</h4>
        <table>
            <thead>
                <tr>
                    <th>Nama Produk</th>
                    <th>Jumlah Terjual</th>
                    <th>Total Omset</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($produkTerjual as $item)
<tr>
    <td>{{ $item->nama_barang }}</td>
    <td class="text-end">{{ $item->total_terjual }} pcs</td>
</tr>
@endforeach

            </tbody>
        </table>
    </div>
    

    <div class="section">
        <h4>Barang Tidak Laku</h4>
        <table>
            <thead>
                <tr>
                    <th>Nama Produk</th>
                    <th>Stok</th>
                    <th>Harga Beli</th>
                    <th>Harga Jual</th>
                </tr>
            </thead>
            <tbody>
                @forelse($produkTidakLaku as $item)
                    <tr>
                        <td>{{ $item->nama_barang }}</td>
                        <td>{{ $item->stok }}</td>
                        <td>Rp{{ number_format($item->harga_beli, 0, ',', '.') }}</td>
                        <td>Rp{{ number_format($item->harga_jual, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">Semua produk pernah terjual</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="section">
        <h4>Barang Perlu Restok</h4>
        <table>
            <thead>
                <tr>
                    <th>Nama Produk</th>
                    <th>Stok</th>
                    <th>Harga Beli</th>
                </tr>
            </thead>
            <tbody>
                @forelse($barangRestok as $item)
                    <tr>
                        <td>{{ $item->nama_barang }}</td>
                        <td>{{ $item->stok }}</td>
                        <td>Rp{{ number_format($item->harga_beli, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">Semua stok aman</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>
