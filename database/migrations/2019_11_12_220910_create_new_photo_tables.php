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
            $table->integer('file_id');
            $table->integer('album_id');
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
            $table->integer('event_id')->nullable()->default(null);
            $table->boolean('private');
            $table->boolean('published')->default(False);
        });


        Schema::create('photo_likes', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('photo_id');
            $table->integer('user_id');
        });

        Schema::table('flickr_albums', function (Blueprint $table) {
            $table->boolean('migrated')->default(False);
        });

        Schema::table('flickr_items', function (Blueprint $table) {
            $table->boolean('migrated')->default(False);
        });

        Schema::table('flickr_likes', function (Blueprint $table) {
            $table->boolean('migrated')->default(False);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('flickr_albums', function (Blueprint $table) {
            $table->dropColumn('migrated');
        });

        Schema::table('flickr_items', function (Blueprint $table) {
            $table->dropColumn('migrated');
        });

        Schema::table('flickr_likes', function (Blueprint $table) {
            $table->dropColumn('migrated');
        });

        Schema::dropIfExists('photo_likes');
        Schema::rename('flickr_likes', 'photo_likes');
        Schema::dropIfExists('photo_albums');
        Schema::dropIfExists('photos');
    }
}
