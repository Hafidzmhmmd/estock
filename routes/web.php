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

Route::middleware(['auth'])->group(function () {
    Route::get('/', 'DashboardController@index')->name('dashboard');

    Route::prefix('pengajuan')->name('pengajuan.')->group(function () {
        Route::get('pembelian', 'PengajuanController@pembelian')->name('pembelian');
    });

    Route::prefix('gudang')->name('gudang.')->group(function () {
        Route::get('/', 'GudangController@index')->name('index');
    });

    Route::prefix('data')->name('data.')->group(function () {
        Route::get('barang', 'DataController@dataBarang')->name('barang');
        Route::get('barangDataTables', 'DataController@barangDataTables')->name('barangDataTables');
        Route::get('stockgudangDataTables', 'DataController@stockgudangDataTables')->name('stockgudangDataTables');
    });
});
