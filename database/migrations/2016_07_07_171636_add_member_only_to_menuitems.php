<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

class AddMemberOnlyToMenuitems extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('menuitems', function ($table) {
            $table->boolean('is_member_only');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('menuitems', function ($table) {
            $table->dropColumn('is_member_only');
        });
    }
}
