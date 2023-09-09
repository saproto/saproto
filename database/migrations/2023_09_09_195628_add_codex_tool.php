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
        Schema::create('codex_text_types', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->timestamps();
        });

        Schema::create('codex_texts', function (Blueprint $table) {
            $table->id();
            $table->integer('type_id')->unsigned();
            $table->string('name');
            $table->longText('text');
            $table->timestamps();
        });

        Schema::create('codex_songs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('artist')->nullable();
            $table->longText('lyrics');
            $table->string('youtube')->nullable();
            $table->timestamps();
        });

        Schema::create('codex_codices', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('export')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });


        Schema::create('codex_category', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('codex_codex_text', function (Blueprint $table) {
            $table->id();
            $table->integer('codex')->unsigned();
            $table->integer('text_id')->unsigned();
            $table->integer('text_index')->unsigned();
            $table->timestamps();
        });

        Schema::create('codex_codex_song', function (Blueprint $table) {
            $table->id();
            $table->integer('codex')->unsigned();
            $table->integer('song')->unsigned();
            $table->integer('category')->unsigned();
            $table->timestamps();
        });

        Schema::create('codex_category_song', function (Blueprint $table) {
            $table->id();
            $table->integer('category')->unsigned();
            $table->integer('song')->unsigned();
            $table->timestamps();
        });

        Schema::create('codex_codexshuffle', function (Blueprint $table) {
            $table->id();
            $table->integer('codex')->unsigned();
            $table->integer('category')->unsigned();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('codex_codexshuffle');
        Schema::dropIfExists('codex_category_song');
        Schema::dropIfExists('codex_codex_song');
        Schema::dropIfExists('codex_codex_text');
        Schema::dropIfExists('codex_category');
        Schema::dropIfExists('codex_codices');
        Schema::dropIfExists('codex_songs');
        Schema::dropIfExists('codex_texts');
        Schema::dropIfExists('codex_text_types');
    }
};
