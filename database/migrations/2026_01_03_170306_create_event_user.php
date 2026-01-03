<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('event_user', function (Blueprint $table) {
            $table->foreignId('event_id');
            $table->foreignId('user_id');
            $table->timestamps();
        });

        Schema::table('events', function (Blueprint $table) {
            $table->boolean('has_interested')->default(false);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_user');

        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('has_interested');
        });
    }
};
