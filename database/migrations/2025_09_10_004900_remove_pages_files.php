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
        Schema::dropIfExists('pages_files');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('pages_files', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('page_id')->unsigned();
            $table->bigInteger('file_id')->unsigned();

            $table->foreign('page_id')->references('id')->on('pages')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('file_id')->references('id')->on('files');
        });
    }
};
