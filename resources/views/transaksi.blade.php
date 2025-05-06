<!DOCTYPE html>
<html lang="id">
<head>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta charset="UTF-8">
  <title>Hazel ATK - Transaksi</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/@mdi/font@6.5.95/css/materialdesignicons.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
   :root {
  --primary: #4a6fa5;
  --accent: #ff7e5f;
  --dark: #1e1e2d;
  --light: #f8f9fa;
}
body {
  background-color: #f1f5f9;
  font-family: 'Segoe UI', sans-serif;
}
.sidebar {
  position: fixed; top: 0; left: 0; height: 100vh; width: 220px;
  background: linear-gradient(180deg, var(--dark), #27293d);
  color: #fff; box-shadow: 2px 0 8px rgba(0,0,0,0.2);
  z-index: 1030; overflow-y: auto;
}
.sidebar a {
  color: rgba(255,255,255,0.9);
  text-decoration: none;
  padding: 12px 20px;
  display: flex;
  align-items: center;
  font-weight: 500;
  border-left: 4px solid transparent;
  transition: 0.3s;
}
.sidebar a i {
  margin-right: 10px; width: 24px; text-align: center;
}
.sidebar a.active, .sidebar a:hover {
  background-color: rgba(255,255,255,0.1);
  border-left: 4px solid var(--accent);
}
.main-content {
  margin-left: 220px;
  padding: 2rem;
}
.table-wrapper {
  background-color: #fff;
  border-radius: 10px;
  padding: 1rem;
  box-shadow: 0 2px 8px rgba(0,0,0,0.05);
  overflow-x: auto;
}
.table-wrapper table {
  font-size: 0.75rem; 
}
.table-wrapper th, .table-wrapper td {
  padding: 4px 6px; 
}
.order-section {
  background: #fff;
  border-radius: 10px;
  padding: 1.5rem;
  box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}
.order-item {
  border-bottom: 1px dashed #ddd;
  padding: 0.5rem 0;
  margin-bottom: 0.5rem;
}
.qty-controls {
  display: flex;
  flex-direction: row; 
  flex-wrap: wrap;     
  gap: 10px;
  margin-top: 0.5rem;
}

.qty-controls button {
  padding: 4px 10px; background-color: #10b981;
  border: none; border-radius: 5px;
  color: #fff; font-size: 14px;
}
.summary {
  margin-top: 1rem; background: #f8f9fa;
  padding: 1rem; border-radius: 8px;
}
.summary div {
  display: flex; justify-content: space-between;
  margin-bottom: 0.5rem;
}
.total {
  font-weight: bold; font-size: 1.25rem;
}
.payment-input input {
  width: 100%; padding: 10px;
  border-radius: 6px; border: 1px solid #ccc;
  margin-top: 0.5rem;
}
.quick-cash-buttons {
  margin-top: 0.5rem; display: flex;
  flex-wrap: wrap; gap: 0.5rem;
}
.quick-cash-buttons .btn-cash {
  flex: 1 0 30%; background: var(--primary);
  color: white; padding: 8px; border: none;
  border-radius: 6px; cursor: pointer;
  font-size: 14px; transition: 0.2s;
}
.print-btn {
  background-color: var(--accent);
  border: none; border-radius: 6px;
  color: white; width: 100%;
  padding: 12px; font-size: 16px;
  margin-top: 1rem; cursor: pointer;
  transition: 0.2s ease-in-out;
}
.order-item h4 {
  font-size: 16px;
  font-weight: 600;
  margin-bottom: 4px;
  color: #333;
}

.print-btn:hover {
  background-color: #ff977f;
}
.popup {
  display: none; position: fixed;
  top: 0; left: 0; width: 100%; height: 100%;
  background-color: rgba(0,0,0,0.4);
  justify-content: center; align-items: center;
  z-index: 999;
}
.popup-content {
  background: #fff; padding: 2rem;
  border-radius: 10px; text-align: center;
  max-width: 400px; width: 90%;
  animation: fadeIn 0.3s ease-in-out;
}
@keyframes fadeIn {
  from { opacity: 0; transform: translateY(-20px); }
  to { opacity: 1; transform: translateY(0); }
}
@media (max-width: 768px) {
  .sidebar {
    width: 100%; height: auto; position: absolute;
  }
  .main-content {
    margin-left: 0 !important;
    padding: 1rem;
  }
}
.table-wrapper {
  max-width: 100%; /* atau 700px, 600px sesuai selera */
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
    <i class="fas fa-tachometer-alt"></i> Dashboard
  </a>
  <a href="{{ route('produk.index') }}" class="{{ request()->is('produk*') ? 'active' : '' }}">
    <i class="fas fa-box-open"></i> Data Barang
  </a>
  <a href="{{ route('transaksi') }}" class="{{ request()->is('transaksi') ? 'active' : '' }}">
    <i class="fas fa-exchange-alt"></i> Transaksi
  </a>
  <a href="{{ route('riwayat') }}" class="{{ request()->is('riwayat') ? 'active' : '' }}">
    <i class="fas fa-history"></i> Riwayat
  </a>
  <a href="{{ route('laporan') }}" class="{{ request()->is('laporan') ? 'active' : '' }}">
    <i class="fas fa-chart-bar"></i> Laporan
  </a>
  <a href="#"><i class="fas fa-cog"></i> Pengaturan</a>
</nav>

<!-- Main Content -->
<main class="main-content">
  <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
    <h1 class="h4 fw-bold text-primary"><i class="mdi mdi-cart me-2"></i>Transaksi</h1>
    <div class="d-flex align-items-center gap-3">
      <img src="https://ui-avatars.com/api/?name=Samuel+Slanturi&background=4a6fa5&color=fff" width="40" class="rounded-circle">
      <span class="fw-bold">Samuel Slanturi</span>
    </div>
  </div>

  <div class="row g-4">
    <!-- Produk -->
    <div class="col-lg-5">
      <div class="table-wrapper mb-4">
        <input type="text" class="form-control mb-3" placeholder="Cari berdasarkan ID atau Nama Barang...">
        <table class="table table-sm">
          <thead>
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

    <!-- Order -->
    <div class="col-lg-7">
      <div class="order-section">
        <div id="order-list"></div>

        <div class="summary">
          <div><span>Subtotal</span><span id="subtotal">Rp0</span></div>
          <div><span>Pajak</span><span>Rp0</span></div>
          <div class="total"><span>Total</span><span id="total">Rp0</span></div>
        </div>

        <div class="payment-input mt-3">
          <label for="uangDiterima">Uang Diterima:</label>
          <input type="number" id="uangDiterima" name="uang_diterima" placeholder="Masukkan nominal uang">
        </div>

        <div class="quick-cash-buttons">
          @foreach ([2000, 5000, 10000, 20000, 50000, 100000] as $nominal)
            <button type="button" class="btn-cash" onclick="tambahUangDiterima({{ $nominal }})">
              +Rp{{ number_format($nominal, 0, ',', '.') }}
            </button>
          @endforeach
        </div>

        <button class="print-btn mt-3" id="bayarButton"><i class="fas fa-cash-register"></i> Bayar</button>
      </div>
    </div>
  </div>

  <!-- Popup pembayaran berhasil -->
  <div class="popup" id="paymentPopup">
    <div class="popup-content">
      <h2>Pembayaran Berhasil!</h2>
      <p>Transaksi #<span id="displayTransactionId"></span></p>
      <div class="popup-buttons mt-4">
        <button class="btn btn-secondary" onclick="closePopup()">Tutup</button>
        <button class="btn btn-primary" onclick="cetakStruk()">Cetak Struk</button>
        <button class="btn btn-success" onclick="selesaikanTransaksi()">Selesai</button>
      </div>
    </div>
  </div>
</main>

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

        <div class="qty-controls" style="display: flex; gap: 15px; flex-wrap: wrap; margin-top: 10px;">
          <div style="display: flex; align-items: center; gap: 5px;">
            <span>Pcs:</span>
            <button onclick="updateQty('${item.id}', 'pcs', -1)">-</button>
            <span>${item.qtyPcs}</span>
            <button onclick="updateQty('${item.id}', 'pcs', 1)">+</button>
          </div>

          ${item.harga_grosir ? `
          <div style="display: flex; align-items: center; gap: 5px;">
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
    </script>

</body>
</html>
