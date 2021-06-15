<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class RegistrationMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('password')->nullable()->default(null)->change();
            $table->boolean('phone_visible')->default(false)->change();
            $table->boolean('address_visible')->default(false)->change();
            $table->boolean('receive_newsletter')->default(false)->change();
            $table->boolean('receive_sms')->default(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('password')->nullable(false)->default('')->change();
            $table->boolean('phone_visible')->default(true)->change();
            $table->boolean('address_visible')->default(true)->change();
            $table->boolean('receive_newsletter')->default(true)->change();
            $table->boolean('receive_sms')->default(true)->change();
        });
    }
}
