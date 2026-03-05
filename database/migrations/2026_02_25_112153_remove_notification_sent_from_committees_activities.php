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
        Schema::table('committees_activities', function (Blueprint $table) {
            $table->dropColumn('notification_sent');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('committees_activities', function (Blueprint $table) {
            $table->boolean('notification_sent')->default(false);
        });
    }
};
