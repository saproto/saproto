<?php

use App\Models\Activity;
use App\Models\Event;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            //rename participants to spots
            $table->renameColumn('participants', 'spots');
        });

        Schema::table('events', function (Blueprint $table) {
            //add a new column that counts the amount of users who signed up called users_count
            $table->unsignedInteger('unique_users_count')->after('publication')->default(0);
        });

        foreach (Event::all() as $event) {
            $allUserIds = collect();
            foreach ($event->tickets as $ticket) {
                if ($ticket->show_participants) {
                    $allUserIds = $allUserIds->merge($ticket->getUsers()->pluck('id'));
                }
            }

            if ($event->activity) {
                $allUserIds = $allUserIds->merge($event->activity->users->pluck('id'));
            }
            
            $event->unique_users_count = $allUserIds->unique()->count();
            $event->save();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            //reverse the up
            $table->renameColumn('spots', 'participants');
        });

        Schema::table('events', function (Blueprint $table) {
            //reverse the up
            $table->dropColumn('unique_users_count');
        });
    }
};
