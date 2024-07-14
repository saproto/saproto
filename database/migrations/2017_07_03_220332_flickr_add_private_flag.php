<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

class FlickrAddPrivateFlag extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('flickr_items', function ($table) {
            $table->boolean('private')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('flickr_items', function ($table) {
            $table->dropColumn('private');
        });
    }
}
