<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hazel ATK - Data Barang</title>
    <style>
       :root {
  --primary-color: #4a6fa5;
  --accent-color: #ff7e5f;
  --light-color: #f8f9fa;
  --dark-color: #1e1e2d;
  --sidebar-width: 220px;
}

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: 'Segoe UI', Tahoma, sans-serif;
}

body {
  background-color: #f1f5f9;
  color: var(--dark-color);
  display: flex;
}

/* Sidebar */
.sidebar {
  width: var(--sidebar-width);
  background: linear-gradient(180deg, var(--dark-color), #27293d);
  color: white;
  height: 100vh;
  position: fixed;
  overflow-y: auto;
  padding-top: 20px;
  z-index: 1000;
}

.sidebar-header {
  padding: 0 20px 20px;
  margin-bottom: 20px;
  border-bottom: 1px solid rgba(255,255,255,0.1);
}

.sidebar-header h2 {
  font-size: 1.4rem;
  display: flex;
  align-items: center;
  color: white;
}

.sidebar-header i {
  margin-right: 10px;
  color: var(--accent-color);
}

.sidebar-menu {
  list-style: none;
}

.sidebar-menu li a {
  display: flex;
  align-items: center;
  padding: 12px 20px;
  color: rgba(255,255,255,0.85);
  text-decoration: none;
  transition: 0.3s;
  border-left: 3px solid transparent;
}

.sidebar-menu li a:hover,
.sidebar-menu li a.active {
  background-color: rgba(255,255,255,0.1);
  color: white;
  border-left: 3px solid var(--accent-color);
}

.sidebar-menu i {
  margin-right: 10px;
  width: 20px;
  text-align: center;
}

/* Main Content */
.main-content {
  margin-left: var(--sidebar-width);
  padding: 20px;
  flex: 1;
}

/* Header */
.header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 25px;
  padding-bottom: 10px;
  border-bottom: 1px solid #e0e0e0;
}

.header h1 {
  font-size: 1.5rem;
  color: var(--primary-color);
}

.user-info {
  display: flex;
  align-items: center;
}

.user-info img {
  width: 38px;
  height: 38px;
  border-radius: 50%;
  margin-right: 10px;
}

/* Card */
.card {
  background-color: white;
  border-radius: 10px;
  padding: 20px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.card-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 15px;
  padding-bottom: 10px;
  border-bottom: 1px solid #eee;
}

.card-header h2 {
  font-size: 1.25rem;
  color: var(--primary-color);
}

/* Buttons */
.btn {
  padding: 7px 14px;
  font-size: 0.85rem;
  border-radius: 5px;
  border: none;
  cursor: pointer;
  font-weight: 500;
  transition: all 0.2s ease-in-out;
}

.btn-primary {
  background-color: var(--accent-color);
  color: white;
}

.btn-primary:hover {
  background-color: #ff977f;
}

.btn-danger {
  background-color: #dc3545;
  color: white;
}

.btn-danger:hover {
  background-color: #b02a37;
}

.btn-secondary {
  background-color: #6c757d;
  color: white;
}

.btn-secondary:hover {
  background-color: #5a6268;
}

/* Table */
.table-responsive {
  overflow-x: auto;
}

table {
  width: 100%;
  border-collapse: collapse;
  font-size: 0.85rem;
}

th, td {
  padding: 8px 10px;
  border-bottom: 1px solid #eee;
  text-align: left;
}

th {
  background-color: var(--light-color);
  color: var(--primary-color);
  font-weight: 600;
}

tr:hover {
  background-color: #f0f4f8;
}

.actions {
  display: flex;
  gap: 6px;
}

.actions .btn {
  padding: 5px 8px;
  font-size: 0.75rem;
}

.actions .btn i {
  font-size: 0.85rem;
}

/* Modal */
.modal {
  display: none;
  position: fixed;
  top: 0; left: 0;
  width: 100%; height: 100%;
  background: rgba(0,0,0,0.5);
  justify-content: center;
  align-items: center;
  z-index: 999;
}

.modal-content {
  background: #fff;
  border-radius: 10px;
  width: 95%;
  max-width: 600px;
  padding: 20px;
  box-shadow: 0 4px 20px rgba(0,0,0,0.15);
  animation: fadeIn 0.3s ease-in-out;
}

@keyframes fadeIn {
  from { opacity: 0; transform: translateY(-10px); }
  to { opacity: 1; transform: translateY(0); }
}

.modal-header,
.modal-footer {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding-bottom: 10px;
  border-bottom: 1px solid #eee;
}

.modal-footer {
  border-top: 1px solid #eee;
  padding-top: 15px;
  margin-top: 15px;
  justify-content: flex-end;
  gap: 10px;
}

.modal-header h3 {
  color: var(--primary-color);
  font-size: 1.2rem;
}

.close {
  background: none;
  border: none;
  font-size: 1.4rem;
  cursor: pointer;
  color: #888;
}

.close:hover {
  color: var(--accent-color);
}

/* Form */
.form-group {
  margin-bottom: 15px;
}

.form-group label {
  font-weight: 500;
  margin-bottom: 5px;
  display: block;
}

.form-control {
  width: 100%;
  padding: 10px;
  font-size: 0.95rem;
  border-radius: 5px;
  border: 1px solid #ccc;
  transition: 0.2s ease-in-out;
}

.form-control:focus {
  border-color: var(--primary-color);
  box-shadow: 0 0 0 2px rgba(74,111,165,0.2);
}

/* Responsive */
@media (max-width: 768px) {
  .sidebar {
    width: 70px;
  }

  .main-content {
    margin-left: 70px;
  }

  .sidebar-header h2 span,
  .sidebar-menu a span {
    display: none;
  }

  .sidebar-menu a {
    justify-content: center;
  }

  .sidebar-menu i {
    margin: 0;
  }
}

    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        
        <div class="sidebar-header">
            <h2><i class="fas fa-boxes"></i> <span>Hazel ATK</span></h2>
        </div>
        <ul class="sidebar-menu">
            <li>
                <a href="{{ route('dashboard') }}" class="{{ request()->is('dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i> <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('produk.index') }}" class="{{ request()->is('produk') || request()->is('produk/*') ? 'active' : '' }}">
                    <i class="fas fa-box-open"></i> <span>Data Barang</span>
                </a>
            </li>
            <li>
                <a href="{{ route('transaksi') }}" class="{{ request()->is('transaksi') ? 'active' : '' }}">
                    <i class="fas fa-exchange-alt"></i> <span>Transaksi</span>
                </a>
            </li>
            <li>
              <a href="{{ route('riwayat') }}" class="{{ request()->is('riwayat') ? 'active' : '' }}">
                <i class="fas fa-history"></i> <span>Riwayat</span>
            </a>        
          </li>
          <li>
            <a href="{{ route('laporan') }}" class="{{ request()->is('laporan') ? 'active' : '' }}">
                <i class="fas fa-chart-bar"></i> <span>Laporan</span>
            </a>
        </li>        
            <li>
                <a href="#"><i class="fas fa-cog"></i> <span>Settings</span></a>
            </li>
        </ul>
        </ul>
        
    </div>

<!-- Main Content -->
<div class="main-content">
    <!-- Header -->
    <div class="header">
        <h1>Data Barang</h1>
        <div class="user-info">
            <img src="https://ui-avatars.com/api/?name=Samuel+Slanturi&background=4a6fa5&color=fff" alt="User">
            <span>Samuel Slanturi</span>
        </div>
    </div>

    <!-- Items Content -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2><i class="fas fa-box-open"></i> Daftar Produk</h2>
            <button class="btn btn-primary" id="add-item-btn"><i class="fas fa-plus"></i> Tambah Produk</button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nama Produk</th>
                            <th>Jumlah Produk</th>
                            <th>Stok (QTY)</th>
                            <th>Modal</th>
                            <th>Harga Jual/pcs</th>
                            <th>Harga Grosir/pcs</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($produk as $item)
                        <tr>
                            <td>{{ $item->nama_barang }}</td>
                            <td>
                                @if ($item->isi_per_paket && $item->satuan_paket)
                                    1 {{ $item->satuan_paket }} isi {{ $item->isi_per_paket }} {{ $item->satuan_dasar }}
                                @else
                                    N/A
                                @endif
                            </td>
                             <td>{{ $item->stok }} {{ $item->satuan_dasar ?? 'N/A' }}</td>
                            <td>{{ number_format($item->harga_beli, 0, ',', '.') }}</td>
                            <td>{{ number_format($item->harga_jual, 0, ',', '.') }}</td>
                            <td>{{ $item->harga_grosir ? number_format($item->harga_grosir, 0, ',', '.') : 'N/A' }}</td>
                            <td class="actions">
                                <!-- Tombol Edit -->
                                <button type="button" class="btn btn-primary btn-sm edit-btn"
                                    data-id="{{ $item->id_barang }}"
                                    data-nama="{{ $item->nama_barang }}"
                                    data-stok="{{ $item->stok }}"
                                    data-satuan="{{ $item->satuan_dasar }}"
                                    data-isi-per-paket="{{ $item->isi_per_paket }}"
                                    data-harga-beli="{{ $item->harga_beli }}"
                                    data-harga-jual="{{ $item->harga_jual }}"
                                    data-harga-grosir="{{ $item->harga_grosir }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                            
                                <!-- Form Hapus -->
                                <form action="{{ route('produk.destroy', $item->id_barang) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin hapus produk ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Modal -->
<!-- Modal -->
<div class="modal" id="item-modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="modal-title">Tambah Barang Baru</h3>
            <button class="close">&times;</button>
        </div>
        <div class="modal-body">
            <form id="item-form" action="{{ route('produk.store') }}" method="POST">
                @csrf
                <input type="hidden" id="item-id" name="id_barang">

                <!-- Nama Produk -->
                <div class="form-group">
                    <label for="item-name">Nama Produk</label>
                    <input type="text" id="item-name" name="nama_barang" class="form-control" required placeholder="Masukkan nama produk">
                </div>

                <!-- Baris: Nama Satuan Paket & Jumlah per Paket -->
                <div class="form-row" style="display: flex; gap: 10px;">
                    <div class="form-group" style="flex: 1;">
                        <label for="item-package">Satuan Paket (misal: kotak, dus)</label>
                        <select id="item-package" name="satuan_paket" class="form-control">
                            <option value="">Pilih Satuan Paket</option>
                            <option value="Pcs">Pcs</option>
                            <option value="Kotak">Kotak</option>
                            <option value="Rim">Rim</option>
                            <option value="Lusin">Lusin</option>
                            <option value="Pack">Pack</option>
                        </select>
                    </div>
                    <div class="form-group" style="flex: 1;">
                        <label for="item-quantity-per-package">Jumlah Satuan Dasar per Paket</label>
                        <input type="number" id="item-quantity-per-package" name="isi_per_paket" class="form-control" value="1" placeholder="cth: 10 pcs per kotak">
                    </div>
                </div>

                <!-- Baris: Stok Awal & Satuan Dasar -->
                <div class="form-row" style="display: flex; gap: 10px;">
                    <div class="form-group" style="flex: 1;">
                        <label for="item-stock">Stok Awal (dalam satuan paket/unit)</label>
                        <input type="number" id="item-stock" name="stok" class="form-control" required placeholder="cth: 50">
                    </div>
                    <div class="form-group" style="flex: 1;">
                        <label for="item-unit">Satuan Dasar (misal: pcs, lembar)</label>
                        <select id="item-unit" name="satuan_dasar" class="form-control" required>
                            <option value="">Pilih Satuan Dasar</option>
                            <option value="Pcs">Pcs</option>
                            <option value="Kotak">Kotak</option>
                            <option value="Rim">Rim</option>
                            <option value="Lusin">Lusin</option>
                            <option value="Pack">Pack</option>
                            <option value="Buah">Buah</option>
                        </select>
                    </div>
                </div>

                <!-- Harga Beli -->
                <div class="form-group">
                    <label for="item-buy-price">Harga Beli per Satuan Dasar</label>
                    <input type="number" id="item-buy-price" name="harga_beli" class="form-control" required placeholder="cth: 12000">
                </div>

                <!-- Harga Jual -->
                <div class="form-group">
                    <label for="item-sell-price">Harga Jual per Satuan Dasar</label>
                    <input type="number" id="item-sell-price" name="harga_jual" class="form-control" required placeholder="cth: 15000">
                </div>

                <!-- Harga Grosir -->
                <div class="form-group">
                    <label for="item-wholesale-price">Harga Grosir per Satuan Dasar (Opsional)</label>
                    <input type="number" id="item-wholesale-price" name="harga_grosir" class="form-control" placeholder="cth: 13000">
                </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary close-btn">Batal</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
            </form>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const itemModal = document.getElementById('item-modal');
        const itemForm = document.getElementById('item-form');
        const modalTitle = document.getElementById('modal-title');
        const addItemBtn = document.getElementById('add-item-btn');
        const closeModalBtns = document.querySelectorAll('.close, .close-btn');

        // Buka modal untuk tambah
        addItemBtn.addEventListener('click', function () {
            modalTitle.textContent = 'Tambah Barang Baru';
            itemForm.action = `{{ route('produk.store') }}`;
            const methodInput = itemForm.querySelector('input[name="_method"]');
            if (methodInput) methodInput.remove();
            itemForm.reset();
            itemModal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        });

        // Tombol edit
        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', function () {
                const id = this.dataset.id;
                const nama = this.dataset.nama;
                const stok = this.dataset.stok;
                const satuan = this.dataset.satuan;
                const hargaBeli = this.dataset.hargaBeli || this.dataset['harga-beli'];
                const hargaJual = this.dataset.hargaJual || this.dataset['harga-jual'];

                modalTitle.textContent = 'Edit Barang';
                itemForm.action = `/produk/${id}`;

                // Tambahkan _method PUT
                let methodInput = itemForm.querySelector('input[name="_method"]');
                if (!methodInput) {
                    methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    itemForm.appendChild(methodInput);
                }
                methodInput.value = 'PUT';

                document.getElementById('item-name').value = nama;
                document.getElementById('item-stock').value = stok;
                document.getElementById('item-unit').value = satuan;
                document.getElementById('item-buy-price').value = hargaBeli;
                document.getElementById('item-sell-price').value = hargaJual;

                itemModal.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            });
        });

        // Tutup modal
        closeModalBtns.forEach(btn => {
            btn.addEventListener('click', function () {
                itemModal.style.display = 'none';
                document.body.style.overflow = 'auto';
                itemForm.reset();
                itemForm.action = `{{ route('produk.store') }}`;
                const methodInput = itemForm.querySelector('input[name="_method"]');
                if (methodInput) methodInput.remove();
            });
        });
    });
</script>

</body>
</html>