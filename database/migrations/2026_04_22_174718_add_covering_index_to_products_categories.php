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
        Schema::table('products_categories', function (Blueprint $table) {
            $table->index(['category_id', 'product_id']);
        });

        Schema::table('products', function (Blueprint $table) {
            $table->index(['name', 'id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products_categories', function (Blueprint $table) {
            $table->dropIndex(['category_id', 'product_id']);
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex(['name', 'id']);
        });
    }
};
