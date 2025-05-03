<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Hazel ATK - Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@6.5.95/css/materialdesignicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
        
        .sidebar {
            background: linear-gradient(180deg, var(--dark), #27293d);
            min-height: 100vh; 
            color: #fff;
            box-shadow: 2px 0 8px rgba(0,0,0,0.2);
            transition: all 0.3s;
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
        
        .navbar-custom {
            background: #ffffff;
            border-bottom: 1px solid #e0e0e0;
            padding: 0.75rem 1.5rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        
        .stat-card {
            background-color: #fff; 
            padding: 20px;
            border-radius: 10px; 
            color: #fff;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            margin-bottom: 20px;
            transition: transform 0.3s;
            border-left: 4px solid;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
        }
        
        .stat-card .icon {
            font-size: 28px; 
            margin-bottom: 15px;
            opacity: 0.8;
        }
        
        .stat-card h5 {
            font-size: 1.5rem;
            font-weight: 700;
        }
        
        .bg-primary { background-color: var(--primary); border-color: var(--primary); }
        .bg-secondary { background-color: var(--secondary); border-color: var(--secondary); }
        .bg-accent { background-color: var(--accent); border-color: var(--accent); }
        .bg-success { background-color: #10b981; border-color: #10b981; }
        .bg-info { background-color: #3b82f6; border-color: #3b82f6; }
        
        .chart-container {
            background: #ffffff;
            border-radius: 10px; 
            padding: 25px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            margin-bottom: 30px;
        }
        
        .chart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .table-card {
            background: #ffffff;
            border-radius: 10px; 
            padding: 25px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }
        
        .table thead th {
            border-bottom-width: 1px;
            font-weight: 600;
            color: #4b5563;
        }
        
        @media (max-width: 768px) {
            .sidebar {
                min-height: auto;
                width: 100%;
            }
            
            .stat-card {
                margin-bottom: 15px;
            }
        }
        .chart-container {
    position: relative;
    min-height: 300px; /* Tinggi minimum */
    max-height: 400px; /* Tinggi maksimum */
}

canvas {
    width: 100% !important;
    height: 100% !important;
}
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-2 col-lg-2 sidebar py-4">
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
        <main class="col-md-10 col-lg-10 ms-sm-auto px-md-4 py-4">
            <!-- Header -->
            <div class="navbar-custom d-flex justify-content-between align-items-center mb-4">
                <h1 class="h4 mb-0 fw-bold"><i class="mdi mdi-view-dashboard-outline me-2"></i>Dashboard</h1>
                <div class="d-flex align-items-center gap-3">
                    <button class="btn btn-sm btn-outline-secondary">
                        <i class="mdi mdi-bell-outline"></i>
                    </button>
                    <img src="https://ui-avatars.com/api/?name=Samuel+Slanturi&background=4a6fa5&color=fff&size=128" 
                         class="rounded-circle" width="40" height="40">
                    <span class="fw-bold">Samuel Slanturi</span>
                </div>
            </div>

            <!-- Statistik Cards -->
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="stat-card" style="background-color: #d1fae5; border-left: 4px solid #10b981; color: #065f46;">
                        <div class="icon"><i class="mdi mdi-cash"></i></div>
                        <div class="mb-2">Laba Bersih Hari Ini</div>
                        <h5>Rp{{ number_format($labaBersih, 0, ',', '.') }}</h5>
                    </div>
                </div>
            
                <div class="col-md-6 col-lg-3">
                    <div class="stat-card" style="background-color: #e0e7ff; border-left: 4px solid #6366f1; color: #3730a3;">
                        <div class="icon"><i class="mdi mdi-currency-usd"></i></div>
                        <div class="mb-2">Laba Kotor Hari Ini</div>
                        <h5>Rp{{ number_format($omsetHariIni, 0, ',', '.') }}</h5>
                    </div>
                </div>
            
                <div class="col-md-6 col-lg-3">
                    <div class="stat-card" style="background-color: #e0f2fe; border-left: 4px solid #0284c7; color: #11777e;">
                        <div class="icon"><i class="mdi mdi-cube-outline"></i></div>
                        <div class="mb-2">Total Stok</div>
                        <h5>{{ $totalStok }}</h5>
                    </div>
                </div>
            
                <div class="col-md-6 col-lg-3">
                    <div class="stat-card" style="background-color: #dbeafe; border-left: 4px solid #3b82f6; color: #1e3a8a;">
                        <div class="icon"><i class="mdi mdi-cube"></i></div>
                        <div class="mb-2">Total Produk</div>
                        <h5>{{ $totalProduk }}</h5>
                    </div>
                </div>
            </div>
            

            <!-- Grafik dan Data Terlaris -->
            <div class="row mt-4 g-4">
                <div class="col-lg-8">
                    <div class="chart-container">
                        <div class="chart-header">
                            <h5 class="mb-0 fw-bold"><i class="mdi mdi-chart-line me-2"></i>Grafik Penjualan</h5>
                            <form method="GET" action="{{ route('dashboard') }}" class="d-flex gap-2">
                                <button class="btn btn-sm btn-outline-primary chart-toggle active" data-type="penjualan" type="button">
                                    Penjualan
                                </button>
                                <button class="btn btn-sm btn-outline-primary chart-toggle" data-type="laba" type="button">
                                    Laba
                                </button>
                                <select name="range" class="form-select form-select-sm w-auto" onchange="this.form.submit()">
                                    <option value="7" {{ $range == 7 ? 'selected' : '' }}>7 Hari</option>
                                    <option value="30" {{ $range == 30 ? 'selected' : '' }}>30 Hari</option>
                                </select>
                            </form>
                            
                        </div>
                        <canvas id="salesChart" height="250"></canvas>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div class="chart-container h-100">
                        <h5 class="fw-bold mb-4"><i class="mdi mdi-star me-2"></i>Barang Terlaris</h5>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Nama Barang</th>
                                        <th class="text-end">Terjual</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($barangTerlaris as $item)
                                    <tr>
                                        <td>{{ $item->produk->nama_barang }}</td>
                                        <td class="text-end">{{ $item->total_terjual }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="2" class="text-center">Belum ada data</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Riwayat Transaksi Terakhir -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="table-card">
                        <h5 class="fw-bold mb-4"><i class="mdi mdi-history me-2"></i>Transaksi Terakhir</h5>
                        <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                            <table class="table table-hover table-sm mb-0">
                                <thead class="table-light sticky-top" style="top: 0; z-index: 10;">
                                    <tr>
                                        <th>No. Transaksi</th>
                                        <th>Tanggal</th>
                                        <th class="text-end">Total</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($transaksiTerakhir as $trx)
                                        <tr>
                                            <td>{{ $trx->kode_transaksi ?? 'TRX-' . str_pad($trx->id, 6, '0', STR_PAD_LEFT) }}</td>
                                            <td>{{ \Carbon\Carbon::parse($trx->tanggal)->translatedFormat('d M Y') }}</td>
                                            <td class="text-end">Rp{{ number_format($trx->total_harga, 0, ',', '.') }}</td>
                                            <td><span class="badge {{ $trx->status == 'Lunas' ? 'bg-success' : 'bg-warning' }}">{{ $trx->status }}</span></td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="5" class="text-center">Belum ada transaksi</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-annotation@1.1.0"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('salesChart')?.getContext('2d');

        if (ctx) {
            const labels = {!! json_encode($penjualan7Hari->pluck('tanggal')->map(fn($d) => \Carbon\Carbon::parse($d)->translatedFormat('d M'))) !!};
            const salesData = {!! json_encode($penjualan7Hari->pluck('total')) !!};
            const profitData = {!! json_encode($penjualan7Hari->pluck('laba')) !!};

            // Hitung rata-rata
            const avgSales = salesData.reduce((a, b) => a + b, 0) / salesData.length;

            const salesChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Total Penjualan',
                            data: salesData,
                            borderColor: 'rgba(74, 111, 165, 1)',
                            backgroundColor: function(ctx) {
                                const gradient = ctx.chart.ctx.createLinearGradient(0, 0, 0, 250);
                                gradient.addColorStop(0, 'rgba(74, 111, 165, 0.3)');
                                gradient.addColorStop(1, 'rgba(74, 111, 165, 0)');
                                return gradient;
                            },
                            borderWidth: 2,
                            tension: 0.4,
                            fill: true,
                            pointRadius: 5,
                            pointBackgroundColor: '#fff',
                            pointBorderColor: 'rgba(74, 111, 165, 1)',
                            pointBorderWidth: 2
                        },
                        {
                            label: 'Laba',
                            data: profitData,
                            borderColor: 'rgba(106, 103, 206, 1)',
                            backgroundColor: 'rgba(106, 103, 206, 0.15)',
                            borderWidth: 2,
                            tension: 0.4,
                            fill: true,
                            pointRadius: 5,
                            pointBackgroundColor: '#fff',
                            pointBorderColor: 'rgba(106, 103, 206, 1)',
                            pointBorderWidth: 2,
                            hidden: true
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: {
                        duration: 1000,
                        easing: 'easeInOutQuart'
                    },
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                usePointStyle: true,
                                padding: 20
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.dataset.label + ': Rp' + context.raw.toLocaleString('id-ID');
                                }
                            }
                        },
                        annotation: {
                            annotations: {
                                avgLine: {
                                    type: 'line',
                                    yMin: avgSales,
                                    yMax: avgSales,
                                    borderColor: 'rgba(255,99,132,0.6)',
                                    borderWidth: 2,
                                    borderDash: [6, 6],
                                    label: {
                                        enabled: true,
                                        content: 'Rata-rata',
                                        position: 'start',
                                        backgroundColor: '#ff7e5f',
                                        color: '#fff',
                                        font: {
                                            weight: 'bold'
                                        }
                                    }
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            suggestedMax: Math.max(...salesData) * 1.2,
                            ticks: {
                                callback: function(value) {
                                    return 'Rp' + value.toLocaleString('id-ID');
                                }
                            },
                            grid: {
                                drawBorder: false,
                                color: 'rgba(0, 0, 0, 0.05)'
                            }
                        },
                        x: {
                            grid: {
                                display: false,
                                drawBorder: false
                            }
                        }
                    }
                }
            });

            // Toggle grafik antara Penjualan dan Laba
            document.querySelectorAll('.chart-toggle').forEach(btn => {
                btn.addEventListener('click', function () {
                    document.querySelectorAll('.chart-toggle').forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                    const type = this.dataset.type;

                    salesChart.data.datasets[0].hidden = (type !== 'penjualan');
                    salesChart.data.datasets[1].hidden = (type !== 'laba');
                    salesChart.update();
                });
            });
        }
    });
</script>


</body>
</html>