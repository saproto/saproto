<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePasswordentryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('passwordstore', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('permission_id');
            $table->string('description')->nullable()->default(null);
            $table->text('username')->nullable()->default(null);
            $table->text('password')->nullable()->default(null);
            $table->string('url')->nullable()->default(null);
            $table->text('note')->nullable()->default(null);
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
        Schema::drop('passwordstore');
    }
}
