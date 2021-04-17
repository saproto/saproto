<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class Committees extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('committees', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name');
            $table->string('slug');
            $table->text('description');

            $table->boolean('public')->default(true);

            $table->timestamps();
        });

        Schema::create('committees_users', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('user_id');
            $table->integer('committee_id');

            $table->string('role')->nullable();
            $table->string('edition')->nullable();

            $table->date('start');
            $table->date('end')->nullable();

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
        Schema::drop('committees');
        Schema::drop('committees_users');
    }
}
