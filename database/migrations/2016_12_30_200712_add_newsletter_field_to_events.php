<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

class AddNewsletterFieldToEvents extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('events', function ($table) {
            $table->boolean('include_in_newsletter')->nullable(false)->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function ($table) {
            $table->dropColumn('include_in_newsletter');
        });
    }
}
