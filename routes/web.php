<?php

use Illuminate\Support\Facades\Route;

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

// Auth
Route::get('/', 'LoginController@login');
Route::post('/login', 'LoginController@login');
Route::post('/logout', 'LoginController@logout');

// Dashboard
Route::get('/dashboard', 'PagesController@dashboard');

// Pegawai
Route::get('/pegawai', 'PegawaiController@index');
Route::get('/pegawai/create', 'PegawaiController@create');
Route::post('/pegawai', 'PegawaiController@store');
Route::get('/pegawai/{id}', 'PegawaiController@show');
Route::get('/pegawai/{id}/edit', 'PegawaiController@edit');
Route::put('/pegawai/{id}/edit', 'PegawaiController@update');

// User
Route::get('/user', 'UserController@index');
Route::get('/user/{id}/profile', 'UserController@edit');
Route::put('/user/{id}/profile', 'UserController@update');
Route::put('/user/{id}/status', 'UserController@ubahStatus');

// Perencanaan
Route::get('/perencanaan', 'PerencanaanController@index');
Route::get('/perencanaan/create', 'PerencanaanController@create');
Route::post('/perencanaan', 'PerencanaanController@store');
Route::get('/perencanaan/{id}', 'PerencanaanController@show');
Route::get('/perencanaan/{id}/edit', 'PerencanaanController@edit');
Route::put('/perencanaan/{id}/edit', 'PerencanaanController@update');
Route::delete('/perencanaan/{id}', 'PerencanaanController@destroy');

// Pengajuan
Route::get('/pengajuan', 'PengajuanController@index');
Route::get('/pengajuan/create', 'PengajuanController@create');
Route::post('/pengajuan', 'PengajuanController@store');
Route::get('/pengajuan/{id}', 'PengajuanController@show');
Route::get('/pengajuan/{id}/edit', 'PengajuanController@edit');
Route::put('/pengajuan/{id}/edit', 'PengajuanController@update');
Route::put('/pengajuan/{id}/ajukan', 'PengajuanController@ajukan_pengajuan');
Route::put('/pengajuan/{id}/persetujuan/{method}', 'PengajuanController@persetujuan');

// Aset
Route::get('/aset', 'AsetController@index');
Route::get('/aset/data/{data}', 'AsetController@data');
Route::get('/aset/create', 'AsetController@create');
Route::post('/aset', 'AsetController@store');
Route::get('/aset/{id}', 'AsetController@show');
Route::get('/aset/create/{id}/pengajuan', 'AsetController@createPengajuan');
Route::get('/aset/{id}/edit', 'AsetController@edit');
Route::put('/aset/{id}/edit', 'AsetController@update');
Route::put('/aset/{id}/generate/qrcode', 'AsetController@generateQRcode');
Route::put('/pengajuan/{id}/penghapusan/', 'AsetController@penghapusan');

// Ruangan
Route::get('/ruangan', 'RuanganController@index');
Route::get('/ruangan/create', 'RuanganController@create');
Route::post('/ruangan', 'RuanganController@store');
Route::get('/ruangan/{id}', 'RuanganController@show');
Route::get('/ruangan/{id}/edit', 'RuanganController@edit');
Route::put('/ruangan/{id}/edit', 'RuanganController@update');

// Penempatan Aset
Route::get('/penempatan', 'PenempatanAsetController@index');
Route::get('/penempatan/create', 'PenempatanAsetController@create');
Route::post('/penempatan', 'PenempatanAsetController@store');
Route::get('/penempatan/data', 'PenempatanAsetController@dataBulanan');
Route::get('/penempatan/create/{id}/pengajuan', 'PenempatanAsetController@createPenempatan');
Route::get('/penempatan/{id}', 'PenempatanAsetController@show');
Route::get('/penempatan/{id}/edit', 'PenempatanAsetController@edit');
Route::put('/penempatan/{id}/edit', 'PenempatanAsetController@update');

// Pengaduan Pengelolaan
Route::get('/pengaduan', 'PengaduanAsetController@index');
Route::get('/pengaduan/create', 'PengaduanAsetController@create');
Route::post('/pengaduan', 'PengaduanAsetController@store');
Route::get('/pengaduan/{id}/edit', 'PengaduanAsetController@edit');
Route::put('/pengaduan/{id}/edit', 'PengaduanAsetController@update');
Route::put('/pengaduan/aset/{id}/status/{method}', 'PengaduanAsetController@ubahStatus');

// Pengaduan
Route::get('/komplen', 'PengaduanController@index');
Route::get('/pengaduan/aset', 'PengaduanController@pengaduan');
Route::post('/pengaduan/aset', 'PengaduanController@pengaduan');
Route::get('/pengaduan/aset/data/{jenis}', 'PengaduanController@dataAset');
Route::get('/komplen/stock', 'PengaduanController@stockAset');

// Pemeliharaan
Route::get('/pemeliharaan', 'PemeliharaanAsetController@index');
Route::get('/pemeliharaan/{id}', 'PemeliharaanAsetController@show');
Route::put('/pemeliharaan/{id}/status/{method}', 'PemeliharaanAsetController@ubahStatus');

// Penghapusan
Route::get('/penghapusan', 'PenghapusanAsetController@index');
Route::get('/penghapusan/{id}', 'PenghapusanAsetController@show');
Route::put('/penghapusan/{id}/status/{method}', 'PenghapusanAsetController@ubahStatus');

// Laporan
Route::get('/laporan/{method}', 'LaporanController@laporanAset');
Route::post('/laporan/download/{method}', 'LaporanController@downloadLaporan');

// Data
Route::get('/role/data', 'DataController@dataRole');
Route::get('/stock/data/kode/{kode}', 'DataController@stockByKode');
