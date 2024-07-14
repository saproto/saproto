<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

class AddOrderToMenuitems extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('menuitems', function ($table) {
            $table->integer('order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('menuitems', function ($table) {
            $table->dropColumn('order');
        });
    }
}
