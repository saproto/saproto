<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AssociateHelpingWithEvents extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->integer('committee_id')->nullable()->default(null);
        });

        Schema::table('activities', function (Blueprint $table) {
            $table->dropColumn('organizing_commitee');
        });
    }

    /**
     * This is a one-way migration!
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('committee_id');
        });

        Schema::table('activities', function (Blueprint $table) {
            $table->integer('organizing_commitee')->nullable()->default(null);
        });
    }
}
