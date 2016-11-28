<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVideoSupportNarrowcasting extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('narrowcasting', function (Blueprint $table) {
            $table->string('youtube_id')->nullable()->default(null);
            $table->integer('image_id')->nullable()->default(null)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('narrowcasting', function (Blueprint $table) {
            $table->dropColumn('youtube_id');
            $table->integer('image_id')->nullable(false)->change();
        });
    }
}
