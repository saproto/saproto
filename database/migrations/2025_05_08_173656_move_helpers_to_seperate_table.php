<?php

use App\Models\ActivityParticipation;
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
        Schema::rename('committees_activities', 'helping_committees_activities');
        Schema::create('helping_committees_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('helping_committee_id')->constrained('helping_committees_activities');
            $table->timestamps();
            $table->softDeletes();
        });

        //activity -> user for participation
        //activity -> helping_committee (committees_activities) -> user


        ActivityParticipation::query()->whereNotNull('committees_activities_id')->chunkById(100, function ($participations) {
            foreach ($participations as $participation) {
                DB::table('helping_committees_users')->insert([
                    'user_id' => $participation->user_id,
                    'helping_committee_id' => $participation->committees_activities_id,
                    'created_at' => $participation->created_at,
                    'updated_at' => $participation->updated_at,
                    'deleted_at' => $participation->deleted_at,
                ]);
            }
        });

        ActivityParticipation::query()->whereNotNull('committees_activities_id')->delete();
        Schema::table('activities_users', function (Blueprint $table) {
            $table->dropColumn('committees_activities_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('helpers', function (Blueprint $table) {
            //
        });
    }
};
