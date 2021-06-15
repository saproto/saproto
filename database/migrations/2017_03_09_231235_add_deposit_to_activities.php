<?php

use Illuminate\Database\Migrations\Migration;

class AddDepositToActivities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('activities', function ($table) {
            $table->float('no_show_fee', 8, 2)->after('price')->default(0.0);
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
            $table->dropColumn('no_show_fee');
        });
    }
}
