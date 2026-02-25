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
        Schema::create('activities_helpers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('committees_activities_id')->constrained()->cascadeOnDelete();
            $table->index(['user_id', 'committees_activities_id']);
            $table->unique(['user_id', 'committees_activities_id']);
            $table->timestamps();
        });

        $rows = DB::table('activities_users')
            ->whereNotNull('committees_activities_id')
            ->whereNull('deleted_at')
            ->get();

        foreach ($rows as $row) {
            DB::table('activities_helpers')->insert([
                'user_id' => $row->user_id,
                'committees_activities_id' => $row->committees_activities_id,
                'created_at' => $row->created_at,
                'updated_at' => $row->updated_at,
            ]);
        }

        DB::table('activities_users')
            ->whereNotNull('committees_activities_id')
            ->delete();

        Schema::table('activities_users', function (Blueprint $table) {
            $table->dropIndex([
                'committees_activities_id',
            ]);
            $table->dropColumn('committees_activities_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities_helpers');
        Schema::table('activities_users', function (Blueprint $table) {
            $table->unsignedBigInteger('committees_activities_id')->nullable()->index();
        });
    }
};
