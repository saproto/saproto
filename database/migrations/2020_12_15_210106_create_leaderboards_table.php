<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeaderboardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leaderboards', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('committee_id');
            $table->string('name');
            $table->string('description');
            $table->string('icon')->nullable();
            $table->string('points_name')->default('points');
            $table->timestamps();
        });

        Schema::create('leaderboards_entries', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('leaderboard_id');
            $table->integer('user_id');
            $table->integer('points')->default(0);
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
        Schema::dropIfExists('leaderboards');
        Schema::dropIfExists('leaderboards_entries');
    }
}