<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MoveSettingsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('pref_calendar_alarm')->after('keep_protube_history')->nullable(true)->default(null);
            $table->boolean('pref_calendar_relevant_only')->after('pref_calendar_alarm')->nullable(false)->default(false);
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
            $table->dropColumn('pref_calendar_alarm');
            $table->dropColumn('pref_calendar_relevant_only');
        });
    }
}
