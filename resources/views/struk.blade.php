<!DOCTYPE html>
<html lang="id" style="width: 57mm">
<head>
    <meta charset="UTF-8">
    <title>Struk Transaksi</title>
    <style>
        @page {
            size: 57mm auto;
            margin: 0;
        }
        body {
            width: 57mm;
            margin: 0 auto;
            font-family: 'Courier New', monospace;
            font-size: 12px;
            line-height: 1.2;
        }
        .struk-container {
            padding: 5px;
        }
        .header, .footer {
            text-align: center;
            margin-bottom: 5px;
        }
        .line {
            border-top: 1px dashed #000;
            margin: 5px 0;
        }
        .item {
            margin-bottom: 5px;
        }
        .item-name {
            font-weight: bold;
        }
        .item-detail {
            margin-left: 10px;
        }
        .total-section {
            margin-top: 10px;
            text-align: right;
        }
    </style>
    <script>
        window.onload = function () {
            window.print();
        };
        window.onafterprint = function () {
            window.close();
        };
    </script>
</head>
<body>
    <div class="struk-container">
        <div class="header">
            <h3>HAZEL ATK</h3>
            <div>{{ $transaksi->tanggal->format('d-m-Y H:i') }}</div>
        </div>

        <div class="line"></div>

        @foreach ($transaksi->detailPenjualan as $item)
            @php
                $produk = $item->produk;
                $qty = $item->jumlah;
                $total_harga = $item->total_harga;

                $isiPerPaket = $produk->isi_per_paket ?? 0;
                $hargaEcer = $produk->harga_jual ?? 0;
                $hargaGrosir = $produk->harga_grosir ?? 0;

                $qtyPaket = ($isiPerPaket > 0) ? intdiv($qty, $isiPerPaket) : 0;
                $qtyPcs = ($isiPerPaket > 0) ? ($qty % $isiPerPaket) : $qty;

                $totalHargaPaket = $qtyPaket * $hargaGrosir;
                $totalHargaEcer = $qtyPcs * $hargaEcer;
            @endphp

            <div class="item">
                <div class="item-name">{{ $produk->nama_barang }}</div>
                <div class="item-detail">
                    @if($qtyPcs > 0)
                        {{ $qtyPcs }} pcs x Rp{{ number_format($hargaEcer, 0, ',', '.') }}<br>
                    @endif

                    @if($qtyPaket > 0 && $hargaGrosir > 0)
                        {{ $qtyPaket }} paket ({{ $isiPerPaket }} pcs) = Rp{{ number_format($totalHargaPaket, 0, ',', '.') }}<br>
                    @endif

                    <strong>Total: Rp{{ number_format($total_harga, 0, ',', '.') }}</strong>
                </div>
            </div>
        @endforeach

        <div class="line"></div>

        <div class="total-section">
            <div><strong>Grand Total: Rp{{ number_format($transaksi->total_harga, 0, ',', '.') }}</strong></div>
            <div>Bayar: Rp{{ number_format($transaksi->amount_paid, 0, ',', '.') }}</div>
            <div>Kembali: Rp{{ number_format($transaksi->kembalian, 0, ',', '.') }}</div>
        </div>

        <div class="footer">
            <p>Terima Kasih</p>
        </div>
    </div>
</body>
</html>
