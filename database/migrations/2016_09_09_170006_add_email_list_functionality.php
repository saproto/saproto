<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddEmailListFunctionality extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mailinglists', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description');
            $table->boolean('is_member_only')->defaults(true);
        });

        Schema::create('users_mailinglists', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('list_id');
            $table->text('user_id');
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
        Schema::drop('mailinglists');
        Schema::drop('users_mailinglists');
    }
}
