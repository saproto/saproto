<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::dropIfExists('codex_codexshuffle');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('codex_codexshuffle', function (Blueprint $table) {
            $table->id();
            $table->integer('codex')->unsigned();
            $table->integer('category')->unsigned();
            $table->timestamps();
        });
    }
};
