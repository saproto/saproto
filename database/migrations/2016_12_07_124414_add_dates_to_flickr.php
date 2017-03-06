<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDatesToFlickr extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('flickr_albums', function ($table) {
            $table->integer('date_create');
            $table->integer('date_update');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('flickr_albums', function ($table) {
            $table->dropColumn('date_create');
            $table->dropColumn('date_update');
        });
    }
}
