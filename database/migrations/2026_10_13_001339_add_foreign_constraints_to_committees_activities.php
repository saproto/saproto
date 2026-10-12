<?php

use App\Models\Activity;
use App\Models\Committee;
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
        DB::table('committees_activities')
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('activities')
                    ->whereColumn('activities.id', 'committees_activities.activity_id');
            })
            ->delete();

        Schema::table('committees_activities', function (Blueprint $table) {
            $table->foreign('activity_id')->references('id')->on('activities')->onDelete('cascade');
            $table->foreign('committee_id')->references('id')->on('committees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('committees_activities', function (Blueprint $table) {
            $table->dropForeign(['activity_id']);
            $table->dropForeign(['committee_id']);
        });
    }
};
