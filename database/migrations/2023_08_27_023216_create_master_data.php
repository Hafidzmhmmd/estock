<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMasterData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_gol_barang', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('gol_id');
            $table->string('golongan');
        });

        Schema::create('m_bid_barang', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('bid_id');
            $table->string('gol_id');
            $table->string('bidang');
        });

        Schema::create('m_kel_barang', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('kel_id');
            $table->string('bid_id');
            $table->string('gol_id');
            $table->string('kelompok');
        });

        Schema::create('m_subkel_barang', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('subkel_id');
            $table->string('kel_id');
            $table->string('bid_id');
            $table->string('gol_id');
            $table->string('subkelompok');
        });

        Schema::create('m_sub_subkel_barang', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('sub_subkel_id');
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
            $table->string('identifier');
            $table->integer('harga_maksimum')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('master_barang');
        Schema::dropIfExists('m_gol_barang');
        Schema::dropIfExists('m_bid_barang');
        Schema::dropIfExists('m_kel_barang');
        Schema::dropIfExists('m_subkel_barang');
        Schema::dropIfExists('m_sub_subkel_barang');
        Schema::dropIfExists('m_barang');
    }
}
