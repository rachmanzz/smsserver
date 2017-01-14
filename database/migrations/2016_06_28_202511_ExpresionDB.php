<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ExpresionDB extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expresiondb', function (Blueprint $table) {
            $table->increments('id');
            $table->string('expname')->unique();
            $table->text('values');
            $table->string('encode');
            $table->bigInteger('user');
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
        Schema::drop('expresiondb');
    }
}
