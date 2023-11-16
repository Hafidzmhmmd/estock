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
        Route::post('/transfer', 'GudangController@transferBarang')->name('transfer');
        Route::get('/riwayat', 'GudangController@riwayat')->name('riwayat');
        Route::post('/riwayatDetails', 'GudangController@riwayatDetails')->name('riwayatDetails');
    });

    Route::prefix('barang')->name('barang.')->group(function () {
        Route::post('store', 'BarangController@store')->name('store');
        Route::get('detail/{id}', 'BarangController@detail')->name('detail');
        Route::delete('delete/{id}', 'BarangController@delete')->name('delete');
    });

    Route::prefix('golongan')->name('golongan.')->group(function () {
        Route::post('store', 'GolonganBarangController@store')->name('store');
        Route::get('detail/{id}', 'GolonganBarangController@detail')->name('detail');
        Route::delete('delete/{id}', 'GolonganBarangController@delete')->name('delete');
    });

    Route::prefix('bidang')->name('bidang.')->group(function () {
        Route::post('store', 'BidangBarangController@store')->name('store');
        Route::get('detail/{id}', 'BidangBarangController@detail')->name('detail');
        Route::delete('delete/{id}', 'BidangBarangController@delete')->name('delete');
    });

    Route::prefix('kelompok')->name('kelompok.')->group(function () {
        Route::post('store', 'KelompokController@store')->name('store');
        Route::get('detail/{id}', 'KelompokController@detail')->name('detail');
        Route::delete('delete/{id}', 'KelompokController@delete')->name('delete');
    });

    Route::prefix('subkelompok')->name('subkelompok.')->group(function () {
        Route::post('store', 'SubKelompokController@store')->name('store');
        Route::get('detail/{id}', 'SubKelompokController@detail')->name('detail');
        Route::delete('delete/{id}', 'SubKelompokController@delete')->name('delete');
    });

    Route::prefix('subsubkelompok')->name('subsubkelompok.')->group(function () {
        Route::post('store', 'SubSubKelompokController@store')->name('store');
        Route::get('detail/{id}', 'SubSubKelompokController@detail')->name('detail');
        Route::delete('delete/{id}', 'SubSubKelompokController@delete')->name('delete');
    });

    Route::prefix('user')->name('user.')->group(function () {
        Route::post('store', 'UserController@store')->name('store');
        Route::get('detail/{id}', 'UserController@detail')->name('detail');
        Route::delete('delete/{id}', 'UserController@delete')->name('delete');
    });

    Route::prefix('data')->name('data.')->group(function () {
        Route::get('barang', 'DataController@dataBarang')->name('barang');
        Route::get('golongan', 'DataController@dataGolongan')->name('golongan');
        Route::get('bidang', 'DataController@dataBidang')->name('bidang');
        Route::get('kelompok', 'DataController@dataKelompok')->name('kelompok');
        Route::get('user', 'DataController@dataUser')->name('user');

        Route::get('golonganDataTables', 'DataController@golonganDataTables')->name('golonganDataTables');
        Route::get('bidangDataTables', 'DataController@bidangDataTables')->name('bidangDataTables');
        Route::get('kelompokDataTables', 'DataController@kelompokDataTables')->name('kelompokDataTables');
        Route::get('subkelompokDataTables', 'DataController@subkelompokDataTables')->name('subkelompokDataTables');
        Route::get('subsubkelompokDataTables', 'DataController@subsubkelompokDataTables')->name('subsubkelompokDataTables');
        Route::get('userDataTables', 'DataController@userDataTables')->name('userDataTables');
        Route::get('barangDataTables', 'DataController@barangDataTables')->name('barangDataTables');
        Route::get('pengajuanDataTables', 'DataController@pengajuanDataTables')->name('pengajuanDataTables');
        Route::get('pengajuandetailDataTables', 'DataController@pengajuandetailDataTables')->name('pengajuandetailDataTables');
        Route::get('stockgudangDataTables', 'DataController@stockgudangDataTables')->name('stockgudangDataTables');
        Route::get('grafikDashboard', 'DataController@grafikDashboard')->name('grafikDashboard');
    });


    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::prefix('transaksi')->name('transaksi.')->group(function () {
            Route::get('/', 'LaporanController@transaksi')->name('index');
        });
        Route::get('/opname', 'LaporanController@opname')->name('opname');
        Route::post('/opname', 'LaporanController@createOpname');
        Route::get('/opname/list', 'LaporanController@listOpname')->name('listOpname');

        Route::get('/bukuPersediaan', 'LaporanController@bukuPersediaan')->name('bukupersediaan');
        Route::post('/bukuPersediaan', 'LaporanController@createBukuPersediaan');
        Route::get('/bukuPersediaan/list', 'LaporanController@listBukuPersediaan')->name('listBukuPersediaan');
    });

    Route::get('getfile/{folder}/{filename}', 'FileController@getfile')->name('getfile');
    Route::get('pdf/pengambilan','FileController@pdfPengambilan')->name('pdf.pengamnbilan');
});
