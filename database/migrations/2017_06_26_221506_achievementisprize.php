<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

class Achievementisprize extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('achievement', function ($table) {
            $table->boolean('isPrize')->nullable(false)->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('achievement', function ($table) {
            $table->dropColumn('isPrize');
        });
    }
}
