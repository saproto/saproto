<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use Proto\Models\Activity;
use Proto\Models\Event;

class AssociateHelpingWithEvents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
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
     *
     * @return void
     */
    public function down()
    {

        Schema::table('events', function (Blueprint $table) {

            $table->dropColumn('committee_id');

        });

        Schema::table('activities', function (Blueprint $table) {

            $table->integer('organizing_commitee')->nullable()->default(null);

        });

    }
}
