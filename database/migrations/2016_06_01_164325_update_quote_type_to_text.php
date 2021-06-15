<?php

use Illuminate\Database\Migrations\Migration;

class UpdateQuoteTypeToText extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quotes', function ($table) {
            $table->text('quote')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('quotes', function ($table) {
            $table->string('quote')->change();
        });
    }
}
