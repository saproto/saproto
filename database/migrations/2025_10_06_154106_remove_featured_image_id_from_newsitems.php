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
        Schema::table('newsitems', function (Blueprint $table) {
            $table->dropColumn('featured_image_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('newsitems', function (Blueprint $table) {
            $table->unsignedBigInteger('featured_image_id')->nullable()->index();
        });
    }
};
