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

        // Remove duplicate entries, keeping the one with the highest id (the most recent one).
        $duplicates = DB::table('activities_users')
            ->select('activity_id', 'user_id')
            ->groupBy('activity_id', 'user_id')
            ->havingRaw('COUNT(*) > 1')
            ->get();

        foreach ($duplicates as $duplicate) {
            DB::table('activities_users')
                ->where('activity_id', $duplicate->activity_id)
                ->where('user_id', $duplicate->user_id)
                ->orderBy('id', 'desc')
                ->skip(1)
                ->delete();
        }

        // apply the unique constraint to prevent future duplicates and remove the softdeletes
        Schema::table('activities_users', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
            $table->unique(['activity_id', 'user_id'], 'activities_users_activity_user_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('activities_users', function (Blueprint $table) {
            $table->dropUnique('activities_users_activity_user_unique');
            $table->softDeletes();
        });
    }
};
