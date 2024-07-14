<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

class AddPrepaidOptionToTickets extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
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
     */
    public function down(): void
    {
        Schema::table('tickets', function ($table) {
            $table->dropColumn('is_prepaid');
        });
        Schema::table('ticket_purchases', function ($table) {
            $table->dropColumn('payment_complete');
        });
    }
}
