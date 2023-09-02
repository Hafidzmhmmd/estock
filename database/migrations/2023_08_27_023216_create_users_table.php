<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('username');
            $table->string('password');
            $table->string('role');
            $table->timestamps();
        });

        Schema::create('m_gol_barang', function (Blueprint $table) {
            $table->string('gol_id')->primary();
            $table->string('golongan');
        });

        Schema::create('m_bid_barang', function (Blueprint $table) {
            $table->string('bid_id')->primary();
            $table->string('gol_id');
            $table->string('bidang');
        });

        Schema::create('m_kel_barang', function (Blueprint $table) {
            $table->string('kel_id')->primary();
            $table->string('bid_id');
            $table->string('gol_id');
            $table->string('kelompok');
        });

        Schema::create('m_subkel_barang', function (Blueprint $table) {
            $table->string('subkel_id')->primary();
            $table->string('kel_id');
            $table->string('bid_id');
            $table->string('gol_id');
            $table->string('subkelompok');
        });

        Schema::create('m_sub_subkel_barang', function (Blueprint $table) {
            $table->string('sub_subkel_id')->primary();
            $table->string('subkel_id');
            $table->string('kel_id');
            $table->string('bid_id');
            $table->string('gol_id');
            $table->string('sub_subkelompok');
        });

        Schema::create('m_barang', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('gol_id');
            $table->string('bid_id');
            $table->string('kel_id');
            $table->string('subkel_id');
            $table->string('sub_subkel_id');
            $table->string('kode');
            $table->string('uraian');
            $table->string('satuan');
            $table->integer('harga_maksimum');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('master_barang');
    }
}
