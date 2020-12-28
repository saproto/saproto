<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeaderboardsEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leaderboards_entries', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('leaderboard_id')->nullable(true)->default(null);
            $table->integer('member_id')->nullable(true)->default(null);
            $table->integer('points')->nullable(true)->default(null);
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
        Schema::dropIfExists('leaderboards_entries');
    }
}
