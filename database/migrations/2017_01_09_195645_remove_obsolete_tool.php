<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveObsoleteTool extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::drop('pastries');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('pastries', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id_a');
            $table->integer('user_id_b')->nullable();
            $table->string('person_b')->nullable();
            $table->integer('pastry');
            $table->timestamps();
        });
    }
}
