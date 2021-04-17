<?php

use Illuminate\Database\Migrations\Migration;

class AddDietToUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function ($table) {
            $table->text('diet')->after('phone')->nullable()->default(null);
        });
        Schema::table('events', function ($table) {
            $table->boolean('involves_food')->after('location')->nullable(false)->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function ($table) {
            $table->dropColumn('diet');
        });
        Schema::table('events', function ($table) {
            $table->dropColumn('involves_food');
        });
    }
}
