<?php

use Illuminate\Database\Migrations\Migration;

class AdditionalFlickrData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('flickr_items', function ($table) {
            $table->string('id');
            $table->integer('date_taken');
        });

        Schema::table('flickr_albums', function ($table) {
            $table->integer('date_taken')->nullable()->default(null);
            $table->integer('event_id')->nullable()->default(null);
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
            $table->dropColumn('id');
            $table->dropColumn('date_taken');
        });

        Schema::table('flickr_albums', function ($table) {
            $table->dropColumn('date_taken');
            $table->dropColumn('event_id');
        });
    }
}
