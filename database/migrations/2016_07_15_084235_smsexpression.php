<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Smsexpression extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('smsexpression', function (Blueprint $table) {
            $table->increments('id');
            $table->string('number');
            $table->text('values');
            $table->bigInteger('expressionID');
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
        Schema::drop('smsexpression');
    }
}
