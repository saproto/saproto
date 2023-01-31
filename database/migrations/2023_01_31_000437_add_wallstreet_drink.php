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
        Schema::create('wallstreet_drink', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('end_time');
            $table->bigInteger('start_time');
            $table->float('price_increase');
            $table->float('price_decrease');
            $table->float('minimum_price');
            $table->timestamps();
        });

        Schema::create('wallstreet_drink_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wallstreet_drink_id');
            $table->foreignId('product_id');
            $table->float('price');
            $table->timestamps();
        });

        Schema::table('products', function (Blueprint $table) {
            $table->boolean('does_wallstreet')->default(false);
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
