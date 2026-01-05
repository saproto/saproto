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
        DB::table('activities_users')->whereNotNull('deleted_at')->delete();

        Schema::table('activities_users', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
            $table->unique(
                ['user_id', 'activity_id', 'committees_activities_id'], 'unique_committee_user_activity'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('activities_users', function (Blueprint $table) {
            $table->dropUnique('unique_committee_user_activity');
            $table->softDeletes(); // Restores the deleted_at column
        });

    }
};
