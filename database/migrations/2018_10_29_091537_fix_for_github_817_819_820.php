<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixForGithub817819820 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('show_achievements')->after('show_birthday')->default(true)->nullable(false);
            $table->boolean('keep_omnomcom_history')->after('show_omnomcom_total')->default(true)->nullable(false);
        });
        Schema::table('events', function (Blueprint $table) {
            $table->boolean('is_educational')->after('is_external')->default(false)->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('show_achievements');
            $table->dropColumn('keep_omnomcom_history');
        });
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('is_educational');
        });
    }
}
