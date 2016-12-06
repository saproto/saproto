<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFlickrAlbumsAndItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flickr_albums', function (Blueprint $table) {
            $table->string('id');
            $table->string('name');
            $table->string('thumb');
        });

        Schema::create('flickr_items', function (Blueprint $table) {
            $table->string('url');
            $table->string('thumb');
            $table->string('album_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('flickr_albums');
        Schema::drop('flickr_items');
    }
}
