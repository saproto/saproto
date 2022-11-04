<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDiscountToDinnerforms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dinnerforms', function (Blueprint $table) {
            $table->renameColumn('discount', 'helper_discount');
        });
        Schema::table('dinnerforms', function (Blueprint $table) {
            $table->float('regular_discount')->after('helper_discount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dinnerforms', function (Blueprint $table) {
            $table->dropColumn('regular_discount');
            $table->renameColumn('helper_discount', 'discount');
        });
    }
}
