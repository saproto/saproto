<?php

use Illuminate\Database\Migrations\Migration;

class AddEventDestinationToEmail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('emails', function ($table) {
            $table->integer('to_event')->after('to_list')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('emails', function ($table) {
            $table->dropColumn('to_event');
        });
    }
}
