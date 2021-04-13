<?php

use Illuminate\Database\Migrations\Migration;

class FlickrAddPrivateFlag extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('flickr_items', function ($table) {
            $table->boolean('private')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('flickr_items', function ($table) {
            $table->dropColumn('private');
        });
    }
}
