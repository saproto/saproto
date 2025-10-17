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
        Schema::table('events', function ($table) {
            $table->integer('image_id')->nullable()->default(null);
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function ($table) {
            $table->dropColumn('image_id');
        });
    }
};
