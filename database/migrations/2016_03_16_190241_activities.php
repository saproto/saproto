<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Activities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');

            $table->string('title');
            $table->text('description');
            $table->string('slug');

            $table->datetime('start');
            $table->datetime('end');

            $table->string('fb_id')->nullable();

            $table->timestamps();
        });

        Schema::create('activities', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('event_id');

            $table->float('price')->nullable();
            $table->integer('participants')->nullable();

            $table->datetime('registration_start');
            $table->datetime('registration_end');

            $table->boolean('secret')->default(false);
            $table->boolean('active')->default(false);

            $table->boolean('closed')->default(false);

            $table->timestamps();
        });

        Schema::create('committees_events', function(Blueprint $table) {
            $table->increments('id');

            $table->integer('event_id');
            $table->integer('committee_id');

            $table->integer('amount');

            $table->timestamps();
        });

        Schema::create('activities_users', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('activity_id');
            $table->integer('user_id');

            $table->integer('committees_events_id')->nullable()->default(null);

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
        Schema::drop('events');
        Schema::drop('activities');
        Schema::drop('committees_events');
        Schema::drop('activities_users');
    }
}
