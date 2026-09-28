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
        Schema::dropIfExists('files');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->string('filename');
            $table->string('mime');
            $table->string('original_filename');
            $table->string('hash');
            $table->timestamps();
        });
    }
};
