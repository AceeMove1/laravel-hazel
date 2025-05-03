<!DOCTYPE html>
<html lang="id">
<head>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta charset="UTF-8">
  <title>Hazel ATK - Transaksi</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

  <style>
    :root {
      --primary-color: #4a6fa5;
      --accent-color: #ff7e5f;
      --sidebar-width: 250px;
      --sidebar-collapsed-width: 70px;
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
      display: flex;
      background-color: #f4f6f9;
      transition: margin-left 0.3s ease;
    }

    .sidebar {
      width: var(--sidebar-width);
      background-color: var(--primary-color);
      color: white;
      padding: 20px 0;
      height: 100vh;
      position: fixed;
      transition: width 0.3s ease;
      overflow: hidden;
      z-index: 1000;
    }

    .sidebar.collapsed {
      width: var(--sidebar-collapsed-width);
    }

    .sidebar.collapsed h2 span,
    .sidebar.collapsed .sidebar-menu a span {
      display: none;
    }

    .sidebar.collapsed .sidebar-menu a {
      justify-content: center;
    }

    .sidebar h2 {
      padding: 0 20px 20px;
      margin-bottom: 20px;
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
      display: flex;
      align-items: center;
      white-space: nowrap;
      cursor: pointer;
    }

    .sidebar h2 i {
      margin-right: 10px;
      color: var(--accent-color);
      min-width: 20px;
    }

    .sidebar-menu {
      list-style: none;
    }

    .sidebar-menu a {
      display: flex;
      align-items: center;
      padding: 12px 20px;
      color: rgba(255, 255, 255, 0.8);
      text-decoration: none;
      transition: 0.3s;
      white-space: nowrap;
    }

    .sidebar-menu a:hover,
    .sidebar-menu a.active {
      background-color: rgba(255, 255, 255, 0.1);
      color: #fff;
    }

    .sidebar-menu i {
      margin-right: 10px;
      min-width: 20px;
    }

    .main-content {
      margin-left: var(--sidebar-width);
      padding: 20px;
      width: 100%;
      transition: margin-left 0.3s ease;
    }

    .sidebar.collapsed ~ .main-content {
      margin-left: var(--sidebar-collapsed-width);
    }

    .header {
      margin-bottom: 30px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      border-bottom: 1px solid #ddd;
      padding-bottom: 15px;
    }

    .header h1 {
      color: var(--primary-color);
    }

    .user-info {
      display: flex;
      align-items: center;
      color: #333;
      font-weight: 500;
    }

    .user-info img {
      border-radius: 50%;
      margin-right: 10px;
    }

    .transaksi-container {
      display: flex;
      gap: 20px;
      width: 100%;
    }

    .produk-section {
      flex: 1;
      min-width: 0;
    }

    .search-bar {
      margin-bottom: 15px;
    }

    .search-bar input {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 8px;
    }

    .table-wrapper {
      background-color: white;
      border-radius: 10px;
      padding: 15px;
      box-shadow: 0 0 6px rgba(0, 0, 0, 0.05);
      overflow-x: auto;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      font-size: 0.95rem;
    }
     /* Tambahan gaya untuk tombol cepat uang diterima */
  .quick-cash-buttons {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-top: 10px;
  }

  .quick-cash-buttons .btn-cash {
    flex: 1 0 30%;
    padding: 10px;
    font-size: 14px;
    background: linear-gradient(to bottom right, #6fb1fc, #4364f7);
    color: white;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
  }

  .quick-cash-buttons .btn-cash:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
  }

  .quick-cash-buttons .btn-cash:active {
    transform: scale(0.98);
    box-shadow: none;
  }

  /* Responsif tombol uang diterima di layar kecil */
  @media (max-width: 500px) {
    .quick-cash-buttons .btn-cash {
      flex: 1 0 45%;
    }
  }

    th, td {
      padding: 10px;
      text-align: left;
      border-bottom: 1px solid #eee;
    }

    th {
      background-color: #e4e9f2;
    }

    .order-section {
      width: 400px;
      flex-shrink: 0;
    }

    .order-container {
      background: white;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 8px rgba(0, 0, 0, 0.05);
      position: sticky;
      top: 20px;
    }

    .order-item {
      display: flex;
      justify-content: space-between;
      margin-bottom: 15px;
      border-bottom: 1px dashed #ddd;
      padding-bottom: 10px;
    }

    .order-item h4 {
      font-size: 16px;
      margin-bottom: 4px;
      color: #333;
    }

    .order-item .price {
      color: #4a6fa5;
      font-weight: bold;
    }

    .order-item .qty {
      font-size: 14px;
      color: #888;
    }

    .order-item .qty-controls {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .order-item .qty-controls button {
      background-color: #4a6fa5;
      color: white;
      border: none;
      padding: 5px 10px;
      cursor: pointer;
      font-size: 14px;
      border-radius: 5px;
    }

    .summary {
      margin-top: 20px;
      padding: 15px;
      background: #f8f9fa;
      border-radius: 8px;
      font-size: 15px;
    }

    .summary div {
      display: flex;
      justify-content: space-between;
      margin-bottom: 10px;
    }

   ... .total {
      font-size: 20px;
      font-weight: bold;
      color: #333;
    }

    /* Payment Button Styles */
    .print-btn {
        background-color: #4CAF50;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        width: 100%;
        font-size: 16px;
        transition: background-color 0.3s;
    }

    .print-btn:hover {
        background-color: #45a049;
    }

    /* Popup Styles */
    .popup {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.5);
        z-index: 999;
        justify-content: center;
        align-items: center;
    }

    .popup-content {
        background-color: white;
        padding: 2rem;
        border-radius: 10px;
        text-align: center;
        position: relative;
        animation: slideIn 0.3s ease-out;
    }

    /* Animations */
    @keyframes slideIn {
        from { transform: translateY(-50px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    .checkmark {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        display: block;
        stroke-width: 2;
        stroke: #4bb71b;
        stroke-miterlimit: 10;
        margin: 0 auto;
        animation: checkmarkScale 0.3s ease-in-out 0.9s both;
    }

    .popup-buttons {
        margin-top: 1.5rem;
        display: flex;
        gap: 1rem;
        justify-content: center;
    }

    .cancel-btn {
        background-color: #ff4444;
        color: white;
        padding: 0.5rem 1.5rem;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .receipt-btn {
        background-color: #4bb71b;
        color: white;
        padding: 0.5rem 1.5rem;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    /* Responsive styles */
    @media (max-width: 1200px) {
      .transaksi-container {
        flex-direction: column;
      }
      
      .order-section {
        width: 100%;
      }
    }

    @media (max-width: 768px) {
      .sidebar {
        width: var(--sidebar-collapsed-width);
      }
      
      .sidebar h2 span,
      .sidebar .sidebar-menu a span {
        display: none;
      }
      
      .sidebar .sidebar-menu a {
        justify-content: center;
      }
      
      .main-content {
        margin-left: var(--sidebar-collapsed-width);
      }
    }
    /* Container utama untuk order */
.order-section {
  width: 100%;
  max-width: 800px; /* Lebar maksimal container */
  margin: 0 auto;
  padding: 20px;
  box-sizing: border-box;
}

/* Popup untuk pembayaran */
.popup-content {
  width: 100%;
  max-width: 500px; /* Maksimal lebar popup */
  margin: 0 auto;
  padding: 20px;
  text-align: center;
  background-color: #fff;
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

/* Input untuk uang diterima */
.payment-input {
  margin-top: 1rem;
  width: 100%;
}

.payment-input input {
  width: 100%; /* Lebar penuh sesuai container */
  padding: 12px; /* Padding input */
  font-size: 1rem; /* Ukuran font input */
  border: 1px solid #ddd; /* Border input */
  border-radius: 4px; /* Sudut input membulat */
  box-sizing: border-box; /* Agar padding dan border tidak mempengaruhi ukuran total */
}

/* Tombol bayar */
.print-btn {
  width: 100%;
  padding: 12px;
  font-size: 1rem;
  background-color: #28a745; /* Warna tombol hijau */
  color: white; /* Warna teks putih */
  border: none;
  border-radius: 4px; /* Sudut tombol membulat */
  cursor: pointer;
  margin-top: 1rem;
}

/* Efek hover pada tombol bayar */
.print-btn:hover {
  background-color: #218838;
}

/* Summary box untuk subtotal dan total */
.summary {
  margin-top: 1.5rem;
}

.summary div {
  display: flex;
  justify-content: space-between;
  font-size: 1.2rem;
}

.summary .total {
  font-weight: bold;
  font-size: 1.5rem;
}

/* Optional: Styling untuk button dalam popup */
.popup-buttons {
  display: flex;
  justify-content: center;
  gap: 10px;
}

.popup-buttons button {
  padding: 10px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.cancel-btn {
  background-color: #ccc;
}

.receipt-btn {
  background-color: #007bff;
  color: white;
}

.cancel-btn:hover {
  background-color: #bbb;
}

.receipt-btn:hover {
  background-color: #0056b3;
}
/* Gaya Popup Pembayaran */
.popup-content {
  background: white;
  padding: 2rem;
  border-radius: 10px;
  width: 90%;
  max-width: 400px;
  text-align: center;
  box-shadow: 0 5px 15px rgba(0,0,0,0.3);
  animation: fadeIn 0.3s;
}

@keyframes fadeIn {
  from { opacity: 0; transform: translateY(-20px); }
  to { opacity: 1; transform: translateY(0); }
}

.checkmark-circle {
  stroke: #4CAF50;
  stroke-width: 2;
}

.checkmark-check {
  stroke: #4CAF50;
  stroke-width: 2;
  stroke-linecap: round;
}

/* Tombol Bayar */
.print-btn {
  background: linear-gradient(to right, #4CAF50, #2E8B57);
  transition: all 0.3s;
}

.print-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 5px 10px rgba(0,0,0,0.2);
}

/* Tombol di Popup */
.popup-buttons {
  display: flex;
  gap: 10px;
  justify-content: center;
  margin-top: 20px;
}

.cancel-btn {
  background: #f44336;
}

.receipt-btn {
  background: #2196F3;
  display: flex;
  align-items: center;
  gap: 8px;
}


  </style>
</head>
<body>

  <!-- Sidebar -->
  <div class="sidebar">
    <h2 onclick="toggleSidebar()"><i class="fas fa-boxes"></i> <span>Hazel ATK</span></h2>
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
  </div>

  <!-- Main Content -->
  <div class="main-content">
    <div class="header">
      <h1>Transaksi</h1>
      <div class="user-info">
        <img src="https://ui-avatars.com/api/?name=Samuel+Slanturi&background=4a6fa5&color=fff" width="40">
        <span>Samuel Slanturi</span>
      </div>
    </div>

    <div class="transaksi-container">
      <!-- Daftar Barang + Pencarian -->
      <div class="produk-section">
        <div class="search-bar">
          <input type="text" placeholder="Cari berdasarkan ID atau Nama Barang...">
        </div>
      
        <div class="table-wrapper">
          <table class="table table-bordered table-sm" style="font-size: 0.875rem;">
            <thead class="thead-light">
              <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Isi/Paket</th>
                <th>Harga</th>
                <th>Grosir</th>
                <th>Stok</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($produk as $item)
              <tr>
                <td>{{ $item->id_barang }}</td>
                <td>{{ $item->nama_barang }}</td>
                <td>
                  @if ($item->isi_per_paket && $item->satuan_paket)
                    1 {{ $item->satuan_paket }} isi {{ $item->isi_per_paket }} {{ $item->satuan_dasar }}
                  @else
                    -
                  @endif
                </td>
                <td>Rp{{ number_format($item->harga_jual, 0, ',', '.') }}</td>
                <td>
                  @if ($item->harga_grosir)
                    Rp{{ number_format($item->harga_grosir, 0, ',', '.') }}
                  @else
                    -
                  @endif
                </td>
                <td>{{ $item->stok }} {{ $item->satuan_dasar }}</td>
                <td>
                  <button class="btn btn-success btn-sm"
                    onclick="addToTransaksi(
                      '{{ $item->id_barang }}',
                      '{{ $item->nama_barang }}',
                      {{ $item->harga_jual ?? 0 }},
                      {{ $item->harga_grosir ?? 0 }},
                      '{{ $item->satuan_dasar }}',
                      {{ $item->isi_per_paket ?? 0 }}
                    )">
                    <i class="fas fa-cart-plus"></i>
                  </button>
                </td>
                
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
      
      <!-- Form Transaksi -->
      <div class="order-section">
        <div class="order-container">
          <!-- Modified Popup Structure -->
          <div class="popup" id="paymentPopup">
            <div class="popup-content">
              <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                  <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"/>
                  <path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
              </svg>
              <h2>Pembayaran Berhasil!</h2>
              <p>Transaksi #<span id="displayTransactionId"></span></p>
              <div class="popup-buttons">
                <button class="cancel-btn" onclick="closePopup()">Tutup</button>
                <button class="receipt-btn" onclick="cetakStruk()">Buat Struk</button>
                <button class="done-btn" onclick="selesaikanTransaksi()">Selesai</button>
              </div>
            </div>
          </div>

          <div id="order-list">
          <!-- Items akan ditambahkan di sini -->
          </div>

          <div class="summary">
            <div><span>Subtotal</span><span id="subtotal">Rp0</span></div>
            <div><span>Pajak</span><span>Rp0</span></div>
            <div class="total"><span>Total</span><span id="total">Rp0</span></div>
          </div>

          <!-- Input Uang Diterima -->
          <div class="payment-input" style="margin-top: 1rem;">
            <label for="uangDiterima">Uang Diterima:</label>
            <input type="number" id="uangDiterima" name="uang_diterima" placeholder="Masukkan nominal uang" 
                  style="width: 100%; padding: 8px; margin-top: 5px; border: 1px solid #ddd; border-radius: 4px;">
          </div>
          <!-- Tombol cepat uang diterima -->
<div class="quick-cash-buttons" style="margin-top: 10px; display: flex; flex-wrap: wrap; gap: 8px;">
  @foreach ([2000, 5000, 10000, 20000, 50000, 100000] as $nominal)
    <button type="button" class="btn-cash" 
            onclick="tambahUangDiterima({{ $nominal }})"
            style="flex: 1 0 30%; padding: 8px; background-color: #f0f0f0; border: 1px solid #ccc; border-radius: 4px; cursor: pointer;">
      +Rp{{ number_format($nominal, 0, ',', '.') }}
    </button>
  @endforeach
</div>

          <button class="print-btn" id="bayarButton">
            <i class="fas fa-cash-register"></i> Bayar</button>
        </div>
      </div>
    </div>
  </div>

  <script>
    // Toggle sidebar
    function toggleSidebar() {
      const sidebar = document.querySelector('.sidebar');
      sidebar.classList.toggle('collapsed');
    }
    
    // Variabel global
    let transaksiItems = [];
    let lastTransactionId = null;
    let lastAmountPaid = 0;
    
    // Tutup popup
    function closePopup() {
  const popup = document.getElementById('paymentPopup');
  if (popup) {
    popup.style.display = 'none';
    popup.classList.remove('active'); // kalau pakai class show/active
  }

  // Coba hilangkan semua overlay (kalau ada)
  const overlay = document.querySelector('.popup-overlay');
  if (overlay) {
    overlay.style.display = 'none';
    overlay.classList.remove('active');
  }

  // Pastikan scroll tidak terkunci
  document.body.classList.remove('no-scroll');

  // Optional: hilangkan focus dari popup
  document.activeElement.blur();

  // Reset form biar siap transaksi baru
  resetTransactionForm();
}

    
    // Tampilkan popup pembayaran berhasil
    function showPaymentPopup(transactionId) {
      document.getElementById('displayTransactionId').textContent = transactionId;
      document.getElementById('paymentPopup').style.display = 'flex';
    }
    
    // Cetak struk
    function cetakStruk() {
  if (!lastTransactionId) {
    alert('Tidak ada transaksi yang tersedia untuk dicetak!');
    return;
  }

  // Cuma buka struk, tidak reset form di sini
  const strukWindow = window.open(
    `/struk/${lastTransactionId}?amount_paid=${lastAmountPaid}`,
    '_blank'
  );

  if (!strukWindow || strukWindow.closed || typeof strukWindow.closed === 'undefined') {
    alert('Popup diblokir. Izinkan pop-up untuk mencetak struk!');
  }
}


    
    // Reset form transaksi
    function resetTransactionForm() {
      transaksiItems = [];
      lastTransactionId = null;
      lastAmountPaid = 0;
    
      document.getElementById('order-list').innerHTML = '';
      document.getElementById('uangDiterima').value = '';
      document.getElementById('subtotal').innerText = 'Rp0';
      document.getElementById('total').innerText = 'Rp0';
    }
    function tambahUangDiterima(nominal) {
  const input = document.getElementById('uangDiterima');
  let current = parseInt(input.value || '0');
  if (isNaN(current)) current = 0;
  input.value = current + nominal;
}

    
    // Tombol bayar
    // Tombol bayar
document.getElementById('bayarButton').addEventListener('click', async function () {
  const uangDiterima = parseFloat(document.getElementById('uangDiterima').value);
  const total = parseFloat(document.getElementById('total').innerText.replace(/[^0-9]/g, ''));

  if (!uangDiterima || isNaN(uangDiterima)) {
    alert('Masukkan nominal uang yang valid!');
    return;
  }

  if (uangDiterima < total) {
    alert('Uang yang dibayarkan kurang dari total pembayaran!');
    return;
  }

  lastAmountPaid = uangDiterima;

  try {
    // Kirim data lengkap sesuai controller Laravel
    const produkData = transaksiItems.map(item => ({
      id: item.id,
      qtyPcs: item.qtyPcs,
      qtyPaket: item.qtyPaket,
      harga_jual: item.harga_jual,
      harga_grosir: item.harga_grosir,
      isiPerPaket: item.isiPerPaket
    }));

    const response = await fetch('/transaksi', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
      },
      body: JSON.stringify({
        produk: produkData,
        amount_paid: uangDiterima,
        total_harga: total
      })
    });

    const data = await response.json();

    if (data.success) {
      lastTransactionId = data.data.id_jualan;
      showPaymentPopup(lastTransactionId);
    } else {
      throw new Error(data.message || 'Gagal menyimpan transaksi');
    }
  } catch (error) {
    console.error('Error:', error);
    alert('Terjadi kesalahan: ' + error.message);
  }
});

    // Tambah produk ke transaksi
    function addToTransaksi(id, nama, harga_jual, harga_grosir, satuanDasar, isiPerPaket) {
  const existing = transaksiItems.find(item => item.id === id);

  if (existing) {
    existing.qtyPcs += 1;
  } else {
    transaksiItems.push({
      id,
      nama,
      harga_jual: parseInt(harga_jual),
      harga_grosir: parseInt((harga_grosir + '').replace(/\./g, '')) || 0, // Bersihin titik ribuan
      isiPerPaket: parseInt(isiPerPaket) || 0,
      satuanDasar,
      qtyPcs: 1,
      qtyPaket: 0
    });
  }

  renderOrderList();
}

    // Tampilkan daftar order
    function renderOrderList() {
      const orderList = document.getElementById('order-list');
      orderList.innerHTML = '';
      let subtotal = 0;
    
      transaksiItems.forEach(item => {
        const totalHargaPcs = item.qtyPcs * item.harga_jual;
        const totalHargaPaket = item.qtyPaket * item.isiPerPaket * item.harga_grosir;
        const totalHarga = totalHargaPcs + totalHargaPaket;
        subtotal += totalHarga;
    
        orderList.innerHTML += `
          <div class="order-item">
            <div>
              <h4>${item.nama}</h4>
              <div class="qty">Total: ${item.qtyPcs} ${item.satuanDasar} (Retail) + ${item.qtyPaket} paket (Grosir)</div>
            </div>
            <div class="qty-controls">
              <div style="display: flex; align-items: center; gap: 5px;">
                <span>Pcs:</span>
                <button onclick="updateQty('${item.id}', 'pcs', -1)">-</button>
                <span>${item.qtyPcs}</span>
                <button onclick="updateQty('${item.id}', 'pcs', 1)">+</button>
              </div>
              ${item.harga_grosir ? `
              <div style="display: flex; align-items: center; gap: 5px; margin-top: 5px;">
                <span>Paket:</span>
                <button onclick="updateQty('${item.id}', 'paket', -1)">-</button>
                <span>${item.qtyPaket}</span>
                <button onclick="updateQty('${item.id}', 'paket', 1)">+</button>
              </div>` : ''}
            </div>
            <div class="price">Rp${totalHarga.toLocaleString()}</div>
          </div>
        `;
      });
    
      document.getElementById('subtotal').innerText = `Rp${subtotal.toLocaleString()}`;
      document.getElementById('total').innerText = `Rp${subtotal.toLocaleString()}`;
    }
    
    // Update jumlah barang
    function updateQty(id, tipe, change) {
      const item = transaksiItems.find(i => i.id === id);
      if (!item) return;
    
      if (tipe === 'pcs') {
        item.qtyPcs += change;
        if (item.qtyPcs < 0) item.qtyPcs = 0;
      } else if (tipe === 'paket') {
        item.qtyPaket += change;
        if (item.qtyPaket < 0) item.qtyPaket = 0;
      }
    
      if (item.qtyPcs === 0 && item.qtyPaket === 0) {
        transaksiItems = transaksiItems.filter(i => i.id !== id);
      }
    
      renderOrderList();
    }

    function selesaikanTransaksi() {
  resetTransactionForm();
  closePopup();
}

    </script>
    
</body>
</html>