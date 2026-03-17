<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('activities_users', function (Blueprint $table) {
            $table->index(['activity_id', 'backup', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::table('activities_users', function (Blueprint $table) {
            $table->dropIndex(['activity_id', 'backup', 'user_id']);
        });
    }
};
