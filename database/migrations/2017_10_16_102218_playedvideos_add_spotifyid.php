<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PlayedvideosAddSpotifyid extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('playedvideos', function (Blueprint $table) {
            $table->string('spotify_id', 50)->after('video_title')->nullable()->default(null);
            $table->text('spotify_name')->after('spotify_id')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('playedvideos', function (Blueprint $table) {
            $table->dropColumn('spotify_id');
            $table->dropColumn('spotify_name');
        });
    }
}
