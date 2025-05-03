<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::resource('produk', ProdukController::class);


Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi');



Route::post('/transaksi', [TransaksiController::class, 'store'])->name('transaksi.store');
Route::get('/transaksi/{id}', [TransaksiController::class, 'show'])->name('transaksi.show');
// Route untuk menampilkan struk
Route::get('/struk/{transactionId}', [TransaksiController::class, 'showReceipt'])->name('struk.show');
Route::get('/riwayat', [TransaksiController::class, 'riwayat'])->name('riwayat');

Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan');
Route::get('/laporan/export/pdf', [LaporanController::class, 'exportPdf'])->name('laporan.export.pdf');





