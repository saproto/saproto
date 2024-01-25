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
        Schema::dropIfExists('committees_helper_reminders');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('committees_helper_reminders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->nullable(false);
            $table->integer('committee_id')->nullable(false);
        });
    }
};
