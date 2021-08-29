<?php

use Illuminate\Database\Migrations\Migration;

class RemoveSoftdeleteBank extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bankaccounts', function ($table) {
            $table->dropColumn('deleted_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bankaccounts', function ($table) {
            $table->softDeletes();
        });
    }
}
