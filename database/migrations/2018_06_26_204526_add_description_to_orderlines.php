<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDescriptionToOrderlines extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orderlines', function (Blueprint $table) {
            $table->text('description')->nullable(true)->default(null)->after('payed_with_withdrawal');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orderlines', function (Blueprint $table) {
            $table->dropColumn('description');
        });
    }
}
