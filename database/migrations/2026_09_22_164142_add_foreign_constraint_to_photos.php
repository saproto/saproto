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
        Schema::table('photos', function (Blueprint $table) {
            $table->foreign('album_id')
                ->references('id')
                ->on('photo_albums');
        });

        Schema::table('photo_albums', function (Blueprint $table) {
            $table->foreign('event_id')
                ->references('id')
                ->on('events')
                ->nullOnDelete();

            $table->foreign('thumb_id')
                ->references('id')
                ->on('photos');
        });

        PhotoLikes::query()->whereDoesntHave('user')->delete();

        Schema::table('photo_likes', function (Blueprint $table) {
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('photos', function (Blueprint $table) {
            $table->dropForeign(['album_id']);
        });

        Schema::table('photo_albums', function (Blueprint $table) {
            $table->dropForeign(['event_id']);
            $table->dropForeign(['thumb_id']);
        });

        Schema::table('photo_likes', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
    }
};
