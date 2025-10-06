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
        Schema::dropIfExists('emails_files');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('emails_files', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('email_id');
            $table->unsignedBigInteger('file_id');
            $table->timestamps();
        });
    }
};
