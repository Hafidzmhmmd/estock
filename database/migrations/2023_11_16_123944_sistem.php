<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Sistem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('counter_nomor', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('modul');
            $table->integer('counter');
            $table->integer('tahun');
            $table->timestamps();
        });

        Schema::create('laporan_create', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type');
            $table->string('path');
            $table->integer('author');
            $table->string('nama_barang')->nullable();
            $table->string('periode')->nullable();
            $table->timestamps();
        });

        Schema::create('log_barang', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('barang_id');
            $table->integer('harga_lama');
            $table->integer('harga_baru');
            $table->dateTime('tanggal_update');
            $table->timestamps();
        });

        Schema::create('pengajuan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('draftcode');
            $table->integer('id_pemohon');
            $table->integer('bidang');
            $table->string('status');
            $table->string('nama_penyedia')->nullable();
            $table->string('faktur')->nullable();
            $table->integer('total_keseluruhan')->default(0);
            $table->dateTime('tgl_pengajuan')->nullable();
            $table->dateTime('tgl_disetujui')->nullable();
            $table->dateTime('tgl_konfirmasibeli')->nullable();
            $table->dateTime('tgl_selesai')->nullable();
            $table->dateTime('tgl_tolak')->nullable();
            $table->integer('flow')->nullable();
            $table->timestamps();
        });

        Schema::create('pengajuan_detail', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('draftcode');
            $table->integer('id_barang');
            $table->string('subkel');
            $table->string('nama_barang');
            $table->integer('harga_maksimum')->nullable();
            $table->string('satuan')->default('');
            $table->integer('harga_satuan');
            $table->integer('jumlah_barang');
            $table->integer('total_harga');
            $table->timestamps();
        });

        Schema::create('pengajuan_progress', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('draftcode');
            $table->integer('before');
            $table->integer('after');
            $table->integer('actor');
            $table->timestamps();
        });

        Schema::create('pengambilan_barang', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nomor');
            $table->dateTime('tgl_pengambilan');
            $table->integer('user');
            $table->integer('admin')->nullable();
            $table->string('print_out')->nullable();
            $table->integer('gudang_id');
            $table->timestamps();
        });

        Schema::create('riwayat_gudang', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('keterangan')->nullable();
            $table->integer('arah');
            $table->integer('userid');
            $table->string('draftcode');
            $table->integer('gudangid');
            $table->integer('bidangid');
            $table->timestamps();
        });

        Schema::create('stock_change_log', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('gudangid');
            $table->integer('barangid');
            $table->integer('before');
            $table->integer('after');
            $table->string('draftcode');
            $table->integer('stock_id');
            $table->integer('riwayat_id')->nullable();
            $table->string('keterangan')->nullable();
            $table->integer('jumlah')->nullable();
            $table->integer('status')->default(0);
            $table->timestamps();
        });

        Schema::create('stock_gudang', function (Blueprint $table) {
            $table->bigIncrements('stock_id');
            $table->integer('gudang_id');
            $table->integer('barang_id');
            $table->integer('rencana');
            $table->integer('stock');
            $table->string('draftcode');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('counter_nomor');
        Schema::dropIfExists('laporan_create');
        Schema::dropIfExists('log_barang');
        Schema::dropIfExists('pengajuan');
        Schema::dropIfExists('pengajuan_detail');
        Schema::dropIfExists('pengajuan_progress');
        Schema::dropIfExists('pengambilan_barang');
        Schema::dropIfExists('riwayat_gudang');
        Schema::dropIfExists('stock_change_log');
        Schema::dropIfExists('stock_gudang');
    }
}
