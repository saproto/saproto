<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('feedback_categories', function (Blueprint $table) {
            //add boolean can reply to feedback categories
            $table->boolean('can_reply')->after('review')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('feedback_categories', function (Blueprint $table) {
            //reverse up
            $table->dropColumn('can_reply');
        });
    }
};
