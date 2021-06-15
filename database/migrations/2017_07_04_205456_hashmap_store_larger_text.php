<?php

use Illuminate\Database\Migrations\Migration;

class HashmapStoreLargerText extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hashmap', function ($table) {
            $table->text('value')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hashmap', function ($table) {
            $table->string('value')->change();
        });
    }
}
