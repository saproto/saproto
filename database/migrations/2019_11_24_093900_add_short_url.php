<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddShortUrl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('short_url', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description')->nullable(false);
            $table->string('url')->nullable(false)->unique();
            $table->string('target')->nullable(false);
            $table->integer('clicks')->nullable(false)->default(0);
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
        Schema::drop('short_url');
    }
}
