<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

class EmailsAddActiveMemberDestination extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('emails', function ($table) {
            $table->boolean('to_active')->default(false)->after('to_event');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('emails', function ($table) {
            $table->dropColumn('to_active');
        });
    }
}
