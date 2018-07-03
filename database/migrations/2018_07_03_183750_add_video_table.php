<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVideoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable(false);
            $table->integer('event_id')->nullable(true)->default(null);
            $table->string('youtube_id')->nullable(false);
            $table->string('youtube_title')->nullable(false);
            $table->string('youtube_length')->nullable(false);
            $table->string('youtube_user_id')->nullable(false);
            $table->string('youtube_user_name')->nullable(false);
            $table->string('youtube_thumb_url')->nullable(false);
            $table->date('video_date')->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('videos');
    }
}
