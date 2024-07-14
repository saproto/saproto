<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

class UpdateAchievementTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('achievement', function ($table) {
            $table->dropColumn('img_file_id');
            $table->text('fa_icon')->nullable()->after('desc');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('achievement', function ($table) {
            $table->dropColumn('fa_icon');
            $table->integer('img_file_id')->nullable();
        });
    }
}
