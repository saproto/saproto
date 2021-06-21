<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddNarrowcastingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('narrowcasting', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('image_id');
            $table->integer('campaign_start');
            $table->integer('campaign_end');
            $table->integer('slide_duration');
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
        Schema::drop('narrowcasting');
    }
}
