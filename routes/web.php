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

    Route::get('/pembelian', 'PengajuanController@pembelian')->name('pembelian');
});
