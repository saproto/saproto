<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameIsPrizeToExcludeFromAllAchievements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('achievement', function (Blueprint $table) {
            $table->renameColumn('isPrize', 'excludeFromAllAchievements');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('achievement', function (Blueprint $table) {
            $table->renameColumn('excludeFromAllAchievements', 'isPrize');
        });
    }
}
