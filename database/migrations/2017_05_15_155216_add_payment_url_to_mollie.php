<?php

use Illuminate\Database\Migrations\Migration;

class AddPaymentUrlToMollie extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mollie_transactions', function ($table) {
            $table->string('payment_url')->nullable(true)->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mollie_transactions', function ($table) {
            $table->dropColumn('payment_url');
        });
    }
}
