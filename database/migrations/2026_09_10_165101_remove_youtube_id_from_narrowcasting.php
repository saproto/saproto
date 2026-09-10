<?php

use App\Models\NarrowcastingItem;
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
        NarrowcastingItem::query()->whereNotNull('youtube_id')->get()->each->delete();
        Schema::table('narrowcasting', function (Blueprint $table) {
            $table->dropColumn('youtube_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('narrowcasting', function (Blueprint $table) {
            $table->string('youtube_id')->nullable(false);
        });
    }
};
