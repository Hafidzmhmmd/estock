<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Access extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->integer('group');
            $table->string('pathname');
            $table->integer('has_sub');
            $table->integer('urutan');
            $table->integer('aktif')->default(1);
            $table->timestamps();
        });

        Schema::create('menu_access', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('menuid');
            $table->integer('userid');
            $table->timestamps();
        });

        Schema::create('role_menu', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('role');
            $table->integer('menuid');
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
        //
        Schema::dropIfExists('menu');
        Schema::dropIfExists('menu_access');
        Schema::dropIfExists('role_menu');
    }
}
