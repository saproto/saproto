<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewPhotoTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('photos', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->unsignedInteger('file_id');
            $table->unsignedInteger('album_id');
            $table->integer('date_taken');
            $table->boolean('private');
        });

        Schema::create('photo_albums', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->char('name', 255);
            $table->integer('date_create');
            $table->integer('date_taken');
            $table->integer('thumb_id');
            $table->unsignedInteger('event_id')->nullable()->default(null);
            $table->boolean('private');
            $table->boolean('published')->default(False);
        });

        Schema::rename('photo_likes', 'flickr_likes');

        Schema::create('photo_likes', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('photo_id');
            $table->integer('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('photo_likes');
        Schema::rename('flickr_likes', 'photo_likes');
        Schema::dropIfExists('photo_albums');
        Schema::dropIfExists('photos');
    }
}
