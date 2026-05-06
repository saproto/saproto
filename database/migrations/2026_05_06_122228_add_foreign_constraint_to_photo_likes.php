<?php

use App\Models\PhotoLikes;
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
        PhotoLikes::query()->whereDoesntHave('photo')->delete();

        Schema::table('photo_likes', function (Blueprint $table) {
            $table->foreign('photo_id')
                ->references('id')
                ->on('photos')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('photo_likes', function (Blueprint $table) {
            $table->dropForeign(['photo_id']);
        });
    }
};
