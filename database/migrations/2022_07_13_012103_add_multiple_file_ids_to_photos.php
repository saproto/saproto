<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMultipleFileIdsToPhotos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('photos', function (Blueprint $table) {
            $table->integer('large_file_id')->after('file_id')->nullable();
            $table->integer('medium_file_id')->after('large_file_id')->nullable();
            $table->integer('small_file_id')->after('medium_file_id')->nullable();
            $table->integer('tiny_file_id')->after('small_file_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('photos', function (Blueprint $table) {
            $table->dropColumn('large_file_id');
            $table->dropColumn('medium_file_id');
            $table->dropColumn('small_file_id');
            $table->dropColumn('tiny_file_id');
        });
    }
}
