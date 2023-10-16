<?php

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

Route::get('/login', 'AuthController@login')->name('login');
Route::get('/logout', 'AuthController@logout')->name('logout');
Route::post('/dologin', 'AuthController@doLogin')->name('dologin');

Route::middleware(['access'])->group(function () {
    Route::get('/', 'DashboardController@index')->name('dashboard');

    Route::prefix('pengajuan')->name('pengajuan.')->group(function () {
        Route::get('pembelian', 'PengajuanController@pembelian')->name('pembelian');
        Route::get('draft/{draftcode}', 'PengajuanController@draft')->name('draft');
        Route::post('simpandraft', 'PengajuanController@simpandraft')->name('simpandraft');
        Route::post('ajukan', 'PengajuanController@ajukan')->name('ajukan');
        Route::post('setujuipengajuan/{draftcode}', 'PengajuanController@setujuipengajuan')->name('setujuipengajuan');
        Route::post('tolakpengajuan/{draftcode}', 'PengajuanController@tolakpengajuan')->name('tolakpengajuan');
        Route::delete('hapusdraft/{draftcode}', 'PengajuanController@hapusdraft')->name('hapusdraft');
        Route::get('daftarpembelian', 'PengajuanController@daftarpembelian')->name('daftarpembelian');
        Route::post('konfirmasiBeli', 'PengajuanController@konfirmasiBeli')->name('konfirmasiBeli');
    });

    Route::prefix('gudang')->name('gudang.')->group(function () {
        Route::get('/', 'GudangController@index')->name('index');
        Route::post('/', 'GudangController@takeout')->name('takeout');
        Route::get('/riwayat', 'GudangController@riwayat')->name('riwayat');
        Route::post('/riwayatDetails', 'GudangController@riwayatDetails')->name('riwayatDetails');
    });

    Route::prefix('data')->name('data.')->group(function () {
        Route::get('barang', 'DataController@dataBarang')->name('barang');
        Route::get('barangDataTables', 'DataController@barangDataTables')->name('barangDataTables');
        Route::get('pengajuanDataTables', 'DataController@pengajuanDataTables')->name('pengajuanDataTables');
        Route::get('pengajuandetailDataTables', 'DataController@pengajuandetailDataTables')->name('pengajuandetailDataTables');
        Route::get('stockgudangDataTables', 'DataController@stockgudangDataTables')->name('stockgudangDataTables');
    });

    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/transaksi', 'LaporanController@transaksi')->name('transaksi');
        Route::get('/opname', 'LaporanController@transaksi')->name('opname');
    });

    Route::get('getfile/{folder}/{filename}', 'FileController@getfile')->name('getfile');
    Route::get('pdf/pengambilan','FileController@pdfPengambilan')->name('pdf.pengamnbilan');
});
