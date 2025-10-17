<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
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
};
