<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAddcreatedandupdated extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('utwentes', function ($table) {
            $table->timestamps();
        });
        Schema::table('studies_users', function ($table) {
            $table->timestamps();
        });
        Schema::table('studies', function ($table) {
            $table->timestamps();
        });
        Schema::table('role_user', function ($table) {
            $table->timestamps();
        });
        Schema::table('bankaccounts', function ($table) {
            $table->timestamps();
        });
        Schema::table('addresses', function ($table) {
            $table->timestamps();
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
