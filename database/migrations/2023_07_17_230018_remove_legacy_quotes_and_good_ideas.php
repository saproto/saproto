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
        Schema::dropIfExists('good_ideas');
        Schema::dropIfExists('good_idea_votes');
        Schema::dropIfExists('quotes');
        Schema::dropIfExists('quotes_users');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('good_ideas', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->text('idea');
            $table->timestamps();
        });

        Schema::create('good_idea_votes', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('good_idea_id');
            $table->integer('vote');
            $table->timestamps();
        });

        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->text('quote');
            $table->timestamps();
        });

        Schema::create('quotes_users', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('quote_id');
            $table->timestamps();
        });
    }
};
