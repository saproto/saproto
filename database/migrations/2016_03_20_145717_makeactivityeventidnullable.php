<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Makeactivityeventidnullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('activities', function(Blueprint $table) {
            $table->integer('event_id')->nullable()->default(null)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // We cannot undo nullable in Laravel migrations... :')
    }
}
