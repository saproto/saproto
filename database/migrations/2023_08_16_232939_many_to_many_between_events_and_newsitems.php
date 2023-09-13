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
        Schema::create('event_newsitem', function (Blueprint $table) {
            $table->integer('newsitem_id')->unsigned();

            $table->integer('event_id')->unsigned();
        });

        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('include_in_newsletter');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_newsitem');
    }
};
