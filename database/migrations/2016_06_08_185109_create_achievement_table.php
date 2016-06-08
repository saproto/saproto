<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAchievementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('achievements', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('desc');
            $table->integer('img_file_id');
            $table->string('tier');
            $table->timestamps();
        });

        Schema::create('achievements_users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('achievement_id');
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
        Schema::drop('achievements');
        Schema::drop('achievements_users');
    }
}