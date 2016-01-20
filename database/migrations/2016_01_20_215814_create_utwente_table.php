<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUtwenteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('utwentes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->text('organisational_unit');
            $table->text('mail');
            $table->text('room_number');
            $table->text('phone_number');
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
    }
}
