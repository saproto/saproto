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
        Schema::table('users', function (Blueprint $table) {
            $table->fullText(['name', 'calling_name', 'email', 'utwente_username'], 'user_search_index');
        });

        Schema::table('pages', function (Blueprint $table) {
            $table->fullText(['slug', 'title', 'content'], 'pages_search_index');
        });

        Schema::table('committees', function (Blueprint $table) {
            $table->fullText(['name', 'slug'], 'committees_search_index');
        });

        Schema::table('events', function (Blueprint $table) {
            $table->fullText(['title'], 'events_search_index');
        });

        Schema::table('photo_albums', function (Blueprint $table) {
            $table->fullText(['name'], 'photo_albums_search_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropFullText('user_search_index');
        });
        Schema::table('pages', function (Blueprint $table) {
            $table->dropFullText('pages_search_index');
        });
        Schema::table('committees', function (Blueprint $table) {
            $table->dropFullText('committees_search_index');
        });
        Schema::table('events', function (Blueprint $table) {
            $table->dropFullText('events_search_index');
        });

        Schema::table('photo_albums', function (Blueprint $table) {
            $table->dropFullText('photo_albums_search_index');
        });

    }
};
