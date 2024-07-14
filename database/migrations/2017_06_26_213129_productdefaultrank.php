<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

class Productdefaultrank extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products_categories', function ($table) {
            $table->unsignedInteger('rank')->nullable(false)->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products_categories', function ($table) {
            $table->unsignedInteger('rank')->nullable(false)->default(1)->change();
        });
    }
}
