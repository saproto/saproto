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
        Schema::table('photo_albums', function (Blueprint $table) {
            $table->index(['published', 'private', 'date_taken']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('photo_albums', function (Blueprint $table) {
            $table->dropIndex(['published', 'private', 'date_taken']);
        });
    }
};
