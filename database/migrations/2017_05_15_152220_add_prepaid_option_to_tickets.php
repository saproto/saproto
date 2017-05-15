<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPrepaidOptionToTickets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tickets', function ($table) {
            $table->boolean('is_prepaid')->nullable(false)->default(false);
        });
        Schema::table('ticket_purchases', function ($table) {
            $table->boolean('payment_complete')->nullable(false)->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tickets', function ($table) {
            $table->dropColumn('is_prepaid');
        });
        Schema::table('ticket_purchases', function ($table) {
            $table->dropColumn('payment_complete');
        });
    }
}
