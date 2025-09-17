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
        Schema::table('playedvideos', function (Blueprint $table) {
            $table->float('duration')->after('duration_played')->nullable()->default(null)->comment('Duration of the video in seconds');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('playedvideos', function (Blueprint $table) {
            $table->dropColumn('duration');
        });
    }
};
