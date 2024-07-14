<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

class RemoveSoftdeleteBank extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('bankaccounts', function ($table) {
            $table->dropColumn('deleted_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bankaccounts', function ($table) {
            $table->softDeletes();
        });
    }
}
