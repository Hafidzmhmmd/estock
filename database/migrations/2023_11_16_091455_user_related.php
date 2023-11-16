<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserRelated extends Migration
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
            $table->integer('role');
            $table->integer('bidang');
            $table->timestamps();
        });

        Schema::create('user_role', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama_role');
            $table->integer('aktif')->default(1);
            $table->timestamps();
        });

        Schema::create('user_bidang', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama_bidang');
            $table->integer('aktif')->default(1);
            $table->timestamps();
        });

        Schema::create('gudang', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama_gudang');
            $table->integer('bidang_id');
            $table->integer('aktif')->default(1);
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
        Schema::dropIfExists('users');
        Schema::dropIfExists('user_role');
        Schema::dropIfExists('user_bidang');
        Schema::dropIfExists('gudang');
    }
}
