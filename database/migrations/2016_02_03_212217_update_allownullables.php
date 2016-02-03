<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAllownullables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function ($table) {
            $table->string('utwente_username')->nullable()->change();
        });

        Schema::table('utwentes', function ($table) {
            $table->string('room_number')->nullable()->change();
            $table->string('phone_number')->nullable()->change();
        });

        Schema::table('studies_users', function ($table) {
            $table->dateTime('till')->nullable()->change();
        });

        Schema::table('members', function ($table) {
            $table->dropColumn('till');
            $table->dropColumn('proto_mail');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
