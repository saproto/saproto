<?php

use App\Enums\MembershipTypeEnum;
use App\Enums\VisibilityEnum;
use App\Models\Event;
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
        Schema::table('events', function (Blueprint $table) {
            $table->integer('visibility')->index()->default(VisibilityEnum::PUBLIC)->after('end');
        });

        Event::query()->chunk(25, static function ($events) {
            foreach ($events as $event) {
                if($event->secret){
                    $event->update([
                        'visibility'=>VisibilityEnum::PUBLIC,
                    ]);
                } elseif ($event->publication!=null){
                    $event->update([
                        'visibility'=>VisibilityEnum::SCHEDULED,
                    ]);
                }
            }
        });

        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('secret');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('visibility');
        });
    }
};
