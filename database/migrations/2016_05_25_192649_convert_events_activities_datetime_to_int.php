<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ConvertEventsActivitiesDatetimeToInt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->integer('start')->change();
            $table->integer('end')->change();
        });
        Schema::table('activities', function (Blueprint $table) {
            $table->integer('registration_start')->change();
            $table->integer('registration_end')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->datetime('start')->change();
            $table->datetime('end')->change();
        });
        Schema::table('activities', function (Blueprint $table) {
            $table->datetime('registration_start')->change();
            $table->datetime('registration_end')->change();
        });
    }
}
