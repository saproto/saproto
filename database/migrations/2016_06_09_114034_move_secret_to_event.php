<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MoveSecretToEvent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('activities', function ($table) {
            $table->dropColumn('secret');
            $table->dropColumn('active');
        });
        Schema::table('events', function ($table) {
            $table->boolean('secret')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('activities', function ($table) {
            $table->boolean('secret')->default(false);
            $table->boolean('active')->default(false);
        });
        Schema::table('events', function ($table) {
            $table->dropColumn('secret');
        });
    }
}
