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
//            $table->renameColumn('participants', 'spots');
        });

        Schema::table('events', function (Blueprint $table) {
            //add a new column that counts the amount of users who signed up called users_count
//            $table->unsignedInteger('users_count')->default(0);
        });

        foreach (Event::all() as $event) {
            $allUserIds = collect([]);
            foreach ($event->tickets as $ticket) {
                if ($ticket->show_participants) {
                    $allUserIds = $allUserIds->merge($ticket->getUsers()->pluck('id'));
                }
            }

            if ($event->activity) {
                $allUserIds = $allUserIds->merge($event->activity->users->pluck('id'));
            }
            $event->update(['users_count', $allUserIds->count()]);
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
            $table->dropColumn('users_count');
        });
    }
};
