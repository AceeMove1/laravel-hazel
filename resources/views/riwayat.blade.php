<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hazel ATK - Riwayat Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@6.5.95/css/materialdesignicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary: #4a6fa5;
            --secondary: #6a67ce;
            --accent: #ff7e5f;
            --dark: #1e1e2d;
            --light: #f8f9fa;
        }

        body {
            background-color: #f1f5f9;
            font-family: 'Segoe UI', sans-serif;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 220px;
            background: linear-gradient(180deg, var(--dark), #27293d);
            color: #fff;
            box-shadow: 2px 0 8px rgba(0,0,0,0.2);
            z-index: 1030;
            overflow-y: auto;
            transition: transform 0.3s ease;
        }

        .sidebar a {
            color: rgba(255,255,255,0.9);
            text-decoration: none;
            padding: 12px 20px;
            display: flex;
            align-items: center;
            font-weight: 500;
            transition: 0.2s;
            border-left: 4px solid transparent;
        }

        .sidebar a i {
            margin-right: 10px;
            font-size: 18px;
            width: 24px;
            text-align: center;
        }

        .sidebar a.active, .sidebar a:hover {
            background-color: rgba(255,255,255,0.1);
            border-left: 4px solid var(--accent);
        }

        /* Main content */
        .main-content {
            margin-left: 220px;
            padding: 2rem;
            min-height: 100vh;
            transition: margin-left 0.3s ease;
        }

        .navbar-custom {
            background: #ffffff;
            border-bottom: 1px solid #e0e0e0;
            padding: 0.75rem 1.5rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .table-card {
            background: #ffffff;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            margin-bottom: 30px;
        }

        .table thead th {
            border-bottom-width: 1px;
            font-weight: 600;
            color: #4b5563;
        }

        .table-responsive-fixed {
            max-height: calc(100vh - 300px);
            overflow-y: auto;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: absolute;
                z-index: 999;
            }

            .main-content {
                margin-left: 0 !important;
                padding: 1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <nav class="sidebar py-4">
        <div class="text-center mb-4">
            <img src="https://ui-avatars.com/api/?name=Samuel+Slanturi&background=4a6fa5&color=fff&size=128" 
                 class="rounded-circle mb-2" width="80" height="80">
            <div class="fw-bold">Samuel Slanturi</div>
            <div class="text-muted small">Admin</div>
        </div>

        <a href="{{ route('dashboard') }}" class="{{ request()->is('dashboard') ? 'active' : '' }}">
            <i class="mdi mdi-view-dashboard"></i> Dashboard
        </a>
        <a href="{{ route('produk.index') }}" class="{{ request()->is('produk*') ? 'active' : '' }}">
            <i class="mdi mdi-cube-outline"></i> Data Barang
        </a>
        <a href="{{ route('transaksi') }}" class="{{ request()->is('transaksi') ? 'active' : '' }}">
            <i class="mdi mdi-swap-horizontal"></i> Transaksi
        </a>
        <a href="{{ route('riwayat') }}" class="{{ request()->is('riwayat') ? 'active' : '' }}">
            <i class="mdi mdi-history"></i> Riwayat
        </a>
        <a href="{{ route('laporan') }}" class="{{ request()->is('laporan') ? 'active' : '' }}">
            <i class="mdi mdi-chart-box-outline"></i> Laporan
        </a>
        <a href="#">
            <i class="mdi mdi-cog"></i> Pengaturan
        </a>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        <div class="navbar-custom d-flex justify-content-between align-items-center mb-4">
            <h1 class="h4 mb-0 fw-bold"><i class="mdi mdi-history me-2"></i>Riwayat Transaksi</h1>
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-sm btn-outline-secondary">
                    <i class="mdi mdi-bell-outline"></i>
                </button>
                <img src="https://ui-avatars.com/api/?name=Samuel+Slanturi&background=4a6fa5&color=fff&size=128" 
                     class="rounded-circle" width="40" height="40">
                <span class="fw-bold">Samuel Slanturi</span>
            </div>
        </div>

        <!-- Konten riwayat transaksi -->
        <div class="table-card">
            <form method="GET" class="d-flex gap-3 align-items-center mb-3">
                <label for="tanggal" class="fw-semibold mb-0">Pilih Tanggal:</label>
                <input type="date" id="tanggal" name="tanggal" class="form-control w-auto" value="{{ request('tanggal', now()->toDateString()) }}" onchange="this.form.submit()">
            </form>

            <div class="table-responsive table-responsive-fixed">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No. Transaksi</th>
                            <th>Jam</th>
                            <th>Total</th>
                            <th>Dibayar</th>
                            <th>Kembali</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transaksi as $trx)
                            <tr>
                                <td>{{ $trx->kode_transaksi ?? 'TRX-' . str_pad($trx->id_jualan, 6, '0', STR_PAD_LEFT) }}</td>
                                <td>{{ \Carbon\Carbon::parse($trx->tanggal)->format('H:i') }}</td>
                                <td>Rp{{ number_format($trx->total_harga, 0, ',', '.') }}</td>
                                <td>Rp{{ number_format($trx->amount_paid, 0, ',', '.') }}</td>
                                <td>Rp{{ number_format($trx->kembalian, 0, ',', '.') }}</td>
                                <td><span class="badge {{ $trx->status == 'Lunas' ? 'bg-success' : 'bg-warning' }}">{{ ucfirst($trx->status) }}</span></td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-outline-primary" onclick="window.open('/struk/{{ $trx->id_jualan }}', '_blank')">
                                        <i class="mdi mdi-printer"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="text-center">Tidak ada transaksi</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($transaksi->hasPages())
                <div class="mt-3">
                    {{ $transaksi->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </main>
</body>
</html>
