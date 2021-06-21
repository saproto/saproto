<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class UpdateStudyUsersTableTimeAsInt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('studies_users', function (Blueprint $table) {
            $table->integer('start');
            $table->dropColumn('till');
            $table->integer('end')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('studies_users', function (Blueprint $table) {
            $table->dropColumn('start');
            $table->dropColumn('end');
            $table->date('from')->nullable();
        });
    }
}
