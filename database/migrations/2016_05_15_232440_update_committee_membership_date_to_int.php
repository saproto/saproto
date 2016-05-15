<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCommitteeMembershipDateToInt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('committees_users', function (Blueprint $table) {
            $table->integer('start')->change();
            $table->integer('end')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('committees_users', function (Blueprint $table) {
            $table->date('start')->change();
            $table->date('end')->change();
        });
    }
}
