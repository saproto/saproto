<?php

use Illuminate\Database\Migrations\Migration;

class RemovePrimaryMemberColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('members', function ($table) {
            $table->dropColumn('is_associate');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('members', function ($table) {
            $table->boolean('is_associate');
        });
    }
}
