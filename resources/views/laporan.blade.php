<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan - Hazel ATK</title>
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
    
        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 220px;
            background: linear-gradient(180deg, var(--dark), #27293d);
            color: #fff;
            box-shadow: 2px 0 8px rgba(0, 0, 0, 0.2);
            z-index: 1030;
            overflow-y: auto;
            transition: transform 0.3s ease;
        }
    
        .sidebar.collapsed {
            transform: translateX(-100%);
        }
    
        /* Main content */
        main {
            margin-left: 220px;
            transition: margin-left 0.3s ease;
        }
    
        main.collapsed {
            margin-left: 0 !important;
        }
    
        .sidebar a {
            color: rgba(255, 255, 255, 0.9);
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
    
        .sidebar a.active,
        .sidebar a:hover {
            background-color: rgba(255, 255, 255, 0.1);
            border-left: 4px solid var(--accent);
        }
    
        /* Navbar */
        .navbar-custom {
            background: #ffffff;
            border-bottom: 1px solid #e0e0e0;
            padding: 0.75rem 1.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }
    
        /* Stat cards */
        .stat-card {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            color: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
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
    
        .bg-primary {
            background-color: var(--primary);
            border-color: var(--primary);
        }
    
        .bg-secondary {
            background-color: var(--secondary);
            border-color: var(--secondary);
        }
    
        .bg-accent {
            background-color: var(--accent);
            border-color: var(--accent);
        }
    
        .bg-success {
            background-color: #10b981;
            border-color: #10b981;
        }
    
        .bg-info {
            background-color: #3b82f6;
            border-color: #3b82f6;
        }
    
        .chart-container {
            background: #ffffff;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
            position: relative;
            min-height: 300px;
            max-height: 400px;
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
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }
    
        .table thead th {
            border-bottom-width: 1px;
            font-weight: 600;
            color: #4b5563;
        }
    
        .filter-card {
            background: #ffffff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
        }
    
        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
        }
    
        .section-title i {
            margin-right: 10px;
            font-size: 1.5rem;
        }
    
        canvas {
            width: 100% !important;
            height: 100% !important;
        }
    
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: absolute;
                z-index: 999;
            }
    
            main {
                margin-left: 0 !important;
            }
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
            
            <a href="{{ route('dashboard') }}" class="{{ request()->is('dashboard') ? '' : '' }}">
                <i class="mdi mdi-view-dashboard"></i> Dashboard
            </a>
            <a href="{{ route('produk.index') }}" class="{{ request()->is('produk*') ? '' : '' }}">
                <i class="mdi mdi-cube-outline"></i> Data Barang
            </a>
            <a href="{{ route('transaksi') }}" class="{{ request()->is('transaksi') ? '' : '' }}">
                <i class="mdi mdi-swap-horizontal"></i> Transaksi
            </a>
            <a href="{{ route('riwayat') }}" class="{{ request()->is('riwayat') ? '' : '' }}">
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
            <div class="navbar-custom d-flex justify-content-between align-items-center mb-4"><button id="toggleSidebar" class="btn btn-outline-secondary me-3 d-md-none">
                <i class="mdi mdi-menu"></i>
            </button>
                <h1 class="h4 mb-0 fw-bold"><i class="mdi mdi-chart-box-outline me-2"></i>Laporan Penjualan</h1>
                <div class="d-flex align-items-center gap-3">
                    <button class="btn btn-sm btn-outline-secondary">
                        <i class="mdi mdi-bell-outline"></i>
                    </button>
                    <img src="https://ui-avatars.com/api/?name=Samuel+Slanturi&background=4a6fa5&color=fff&size=128" 
                         class="rounded-circle" width="40" height="40">
                    <span class="fw-bold">Samuel Slanturi</span>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="filter-card">
                <form method="GET" action="{{ route('laporan') }}" class="row g-3" id="filterForm">
                    <!-- Rentang Waktu Dropdown -->
                    <div class="col-md-3">
                        <label for="range" class="form-label">Rentang Waktu</label>
                        <select name="range" id="range" class="form-select" onchange="clearDatesAndSubmit()">
                            <option value="1" {{ request()->get('range', '7') == '1' ? 'selected' : '' }}>1 Hari</option>
                            <option value="3" {{ request()->get('range', '7') == '3' ? 'selected' : '' }}>3 Hari</option>
                            <option value="7" {{ request()->get('range', '7') == '7' ? 'selected' : '' }}>7 Hari</option>
                            <option value="30" {{ request()->get('range', '7') == '30' ? 'selected' : '' }}>30 Hari</option>
                        </select>
                    </div>
            
                    <!-- Input Tanggal Manual -->
                    <div class="col-md-3">
                        <label for="startDate" class="form-label">Dari Tanggal</label>
                        <input type="date" class="form-control" id="startDate" name="start_date"
                               value="{{ request()->get('start_date') }}">
                    </div>
            
                    <div class="col-md-3">
                        <label for="endDate" class="form-label">Sampai Tanggal</label>
                        <input type="date" class="form-control" id="endDate" name="end_date"
                               value="{{ request()->get('end_date') }}">
                    </div>
            
                    <!-- Tombol Aksi -->
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="mdi mdi-filter me-1"></i> Filter
                        </button>
                        <a href="{{ route('laporan.export.pdf', request()->all()) }}" class="btn btn-danger">
                            <i class="mdi mdi-file-pdf me-1"></i> PDF
                        </a>
                    </div>
                </form>
            </div>
            
           <!-- Script: Kosongkan tanggal jika pilih range -->
<script>
    function clearDatesAndSubmit() {
        document.getElementById('startDate').value = '';
        document.getElementById('endDate').value = '';
        document.getElementById('filterForm').submit();
    }
</script>
            
            <!-- Statistik Cards -->
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="stat-card" style="background-color: #d1fae5; border-left: 4px solid #10b981; color: #065f46;">
                        <div class="icon"><i class="mdi mdi-cash"></i></div>
                        <div class="mb-2">Total Pendapatan</div>
                        <h5>Rp{{ number_format($omset->sum('total') ?? 0, 0, ',', '.') }}</h5>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-3">
                    <div class="stat-card" style="background-color: #e0e7ff; border-left: 4px solid #6366f1; color: #3730a3;">
                        <div class="icon"><i class="mdi mdi-currency-usd"></i></div>
                        <div class="mb-2">Laba Bersih</div>
                        <h5>Rp{{ number_format($labaBersih ?? 0, 0, ',', '.') }}</h5>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-3">
                    <div class="stat-card" style="background-color: #e0f2fe; border-left: 4px solid #0284c7; color: #11777e;">
                        <div class="icon"><i class="mdi mdi-package-variant"></i></div>
                        <div class="mb-2">Produk Terjual</div>
                        <h5>{{ $produkTerjual->sum('total_terjual') ?? 0 }} pcs</h5>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-3">
                    <div class="stat-card" style="background-color: #f3e8ff; border-left: 4px solid #9333ea; color: #5b21b6;">
                        <div class="icon"><i class="mdi mdi-chart-line"></i></div>
                        <div class="mb-2">Transaksi</div>
                        <h5>{{ $omset->count() ?? 0 }}</h5>
                    </div>
                </div>
            </div>

            <!-- Grafik -->
            <div class="row mt-4 g-4">
                <div class="col-lg-8">
                    <div class="chart-container">
                        <div class="chart-header">
                            <h5 class="mb-0 fw-bold"><i class="mdi mdi-chart-line me-2"></i>Grafik Penjualan</h5>
                            <div class="btn-group" role="group">
                                <button class="btn btn-sm btn-outline-primary chart-toggle active" data-type="penjualan">
                                    Penjualan
                                </button>
                                <button class="btn btn-sm btn-outline-primary chart-toggle" data-type="laba">
                                    Laba
                                </button>
                            </div>
                        </div>
                        <canvas id="salesChart" height="250"></canvas>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div class="chart-container h-100">
                        <h5 class="fw-bold mb-4"><i class="mdi mdi-star me-2"></i>Barang Terlaris</h5>
                        <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                            <table class="table table-hover table-sm mb-0">                        
                                <thead>
                                    <tr>
                                        <th>Nama Barang</th>
                                        <th class="text-end">Terjual</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($produkTerjual as $item)
                                    <tr>
                                        <td>{{ $item->nama_barang }}</td>
                                        <td class="text-end">{{ $item->total_terjual }} pcs</td>
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

            <!-- Barang Tidak Laku -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="table-card">
                        <h5 class="fw-bold mb-4"><i class="mdi mdi-close-circle-outline me-2"></i>Barang Tidak Laku</h5>
                        <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                            <table class="table table-hover table-sm mb-0">                        
                                <thead>
                                    <tr>
                                        <th>Nama Barang</th>
                                        <th>Stok</th>
                                        <th class="text-end">Harga Jual</th>
                                        <th class="text-end">Harga Beli</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($produkTidakLaku as $item)
                                        <tr>
                                            <td>{{ $item->nama_barang }}</td>
                                            <td>{{ $item->stok }}</td>
                                            <td class="text-end">Rp{{ number_format($item->harga_jual, 0, ',', '.') }}</td>
                                            <td class="text-end">Rp{{ number_format($item->harga_beli, 0, ',', '.') }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="4" class="text-center">Semua barang pernah terjual</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Barang Perlu Restok -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="table-card">
                        <h5 class="fw-bold mb-4"><i class="mdi mdi-alert-circle-outline me-2"></i>Barang Perlu Restok</h5>
                        <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                            <table class="table table-hover table-sm mb-0">
                                <thead>
                                    <tr>
                                        <th>Nama Barang</th>
                                        <th>Stok Tersedia</th>
                                        <th>Stok Minimum</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($barangRestok as $item)
                                        <tr>
                                            <td>{{ $item->nama_barang }}</td>
                                            <td>{{ $item->stok }}</td>
                                            <td>10</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="3" class="text-center">Tidak ada barang perlu restok</td></tr>
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
        // Grafik Penjualan
        const ctx = document.getElementById('salesChart')?.getContext('2d');
        if (ctx) {
            const labels = {!! json_encode($omset->pluck('tanggal')->map(fn($d) => \Carbon\Carbon::parse($d)->translatedFormat('d M'))) !!};
            const salesData = {!! json_encode($omset->pluck('total')) !!};
            const profitData = {!! json_encode(array_values($labaBersihPerHari->toArray())) !!};

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

        // Validasi tanggal
        document.querySelector('form')?.addEventListener('submit', function(e) {
            const startDate = document.getElementById('startDate').value;
            const endDate = document.getElementById('endDate').value;
            if (startDate > endDate) {
                e.preventDefault();
                alert('Tanggal mulai tidak boleh lebih besar dari tanggal akhir.');
            }
        });
    });

    document.getElementById('toggleSidebar')?.addEventListener('click', function () {
    const sidebar = document.querySelector('.sidebar');
    const main = document.querySelector('main');
    sidebar.classList.toggle('collapsed');
    main.classList.toggle('collapsed');
});

    </script>
</body>
</html>