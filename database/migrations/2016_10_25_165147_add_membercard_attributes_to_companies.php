<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMembercardAttributesToCompanies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function ($table) {
            $table->boolean('on_membercard')->default(false);
            $table->text('membercard_excerpt')->nullable();
            $table->text('membercard_long')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('companies', function ($table) {
            $table->dropColumn('on_membercard');
            $table->dropColumn('membercard_excerpt');
            $table->dropColumn('membercard_long');
        });
    }
}
