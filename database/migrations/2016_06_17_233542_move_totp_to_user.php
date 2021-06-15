<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class MoveTotpToUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::drop('google2fa');
        Schema::table('users', function (Blueprint $table) {
            $table->string('tfa_totp_key')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('google2fa', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('secret');
            $table->timestamps();
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('tfa_totp_key');
        });
    }
}
