<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class DefaultMembershipTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->boolean('is_lifelong')->nullable(false)->default(false)->change();
            $table->boolean('is_honorary')->nullable(false)->default(false)->change();
            $table->boolean('is_donator')->nullable(false)->default(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->boolean('is_lifelong')->nullable()->default(null)->change();
            $table->boolean('is_honorary')->nullable()->default(null)->change();
            $table->boolean('is_donator')->nullable()->default(null)->change();
        });
    }
}
