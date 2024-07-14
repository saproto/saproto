<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

class HashmapStoreLargerText extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('hashmap', function ($table) {
            $table->text('value')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hashmap', function ($table) {
            $table->string('value')->change();
        });
    }
}
