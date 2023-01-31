<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWallstreetDrink extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //add table called wallStreetDrink and add the following columns to it: id, end_time, start_time, name
        Schema::create('wallstreet_drink', function (Blueprint $table) {
            $table->id();
            $table->dateTime('end_time');
            $table->dateTime('start_time');
        });

        //make a table that references the wallstreet_drink table and has the following columns: id, wallstreet_drink_id, product_id, price
        Schema::create('wallstreet_drink_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wallstreet_drink_id');
            $table->foreignId('product_id');
            $table->float('price');
            $table->timestamps();
        });

        Schema::table('products', function (Blueprint $table) {
            $table->integer('does_wallstreet')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */

    public function down()
    {
        Schema::dropIfExists('wallstreet_drink');
        Schema::dropIfExists('wallstreet_drink_prices');

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('does_wallstreet');
        });
    }
}
