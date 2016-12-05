<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAutoAssignToAchievements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('achievement', function ($table) {
            $table->boolean('automatic')->default(false);
            $table->text('query')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('achievement', function ($table) {
            $table->dropColumn('automatic');
            $table->dropColumn('query');
        });
    }
}