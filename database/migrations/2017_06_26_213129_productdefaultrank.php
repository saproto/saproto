<?php

use Illuminate\Database\Migrations\Migration;

class Productdefaultrank extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products_categories', function ($table) {
            $table->unsignedInteger('rank')->nullable(false)->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products_categories', function ($table) {
            $table->unsignedInteger('rank')->nullable(false)->default(1)->change();
        });
    }
}
