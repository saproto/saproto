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
        Schema::table('user_welcome', function (Blueprint $table) {
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });

        Schema::table('achievements_users', function (Blueprint $table) {
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('achievement_id')
                ->references('id')
                ->on('achievement')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_welcome', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        Schema::table('achievements_users', function (Blueprint $table) {
            $table->dropForeign(['achievement_id']);
            $table->dropForeign(['user_id']);
        });
    }
};
