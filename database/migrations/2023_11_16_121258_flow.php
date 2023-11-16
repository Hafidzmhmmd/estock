<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Flow extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flow', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('flow_name');
            $table->string('status')->nullable();
            $table->integer('step')->nullable();
            $table->integer('next_flow')->nullable();
            $table->integer('decline')->nullable();
            $table->integer('role')->nullable();
            $table->string('update_date')->nullable();
            $table->integer('proses_rencana')->default(0);
            $table->integer('proses_stock')->default(0);
            $table->integer('can_decline')->default(0);
            $table->integer('can_edit')->default(0);
            $table->integer('input_penyedia')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('flow');
    }
}
