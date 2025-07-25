<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wiki_pages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->foreignId('parent_id')->nullable()->constrained('wiki_pages');
            $table->string('full_path');
            $table->longText('content');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wiki_pages');
    }
};
