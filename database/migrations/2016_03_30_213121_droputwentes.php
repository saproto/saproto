<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Droputwentes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::drop('utwentes');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::create('utwentes', function ($table) {
            $table->increments('id');
            $table->integer('user_id');

            $table->string('organisational_unit');
            $table->string('mail');

            $table->string('room_number')->nullable();
            $table->string('phone_number')->nullable();

            $table->timestamps();
        });

    }
}
