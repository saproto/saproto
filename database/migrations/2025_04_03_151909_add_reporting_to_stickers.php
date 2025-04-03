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
        Schema::table('stickers', function (Blueprint $table) {
            $table->unsignedBigInteger('reporter_id')->nullable()->index()->after('file_id');
            $table->foreign('reporter_id')->references('id')->on('users');
            $table->string('report_reason')->nullable()->after('reporter_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stickers', function (Blueprint $table) {
            $table->dropForeign('stickers_reporter_id_foreign');
            $table->dropColumn('reporter_id');
            $table->dropColumn('report_reason');
        });
    }
};
