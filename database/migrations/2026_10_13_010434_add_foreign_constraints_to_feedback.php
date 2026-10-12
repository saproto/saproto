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
        Schema::table('feedback', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('feedback_category_id')->change();
            $table->foreign('feedback_category_id')->references('id')->on('feedback_categories')->onDelete('cascade');
        });

        Schema::table('feedback_categories', function (Blueprint $table) {
            $table->foreign('reviewer_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::table('feedback_votes', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('feedback_id')->references('id')->on('feedback')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('feedback', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['feedback_category_id']);
        });

        Schema::table('feedback_categories', function (Blueprint $table) {
            $table->dropForeign(['reviewer_id']);
        });

        Schema::table('feedback_votes', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['feedback_id']);
        });
    }
};
