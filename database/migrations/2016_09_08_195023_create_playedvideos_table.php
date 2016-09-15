<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlayedvideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('playedvideos', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->references('id')->on('users')->nullable();
            $table->string('video_id');
            $table->string('video_title');
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
        Schema::drop('playedvideos');
    }
}
