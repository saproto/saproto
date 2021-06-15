<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeMembershipType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('members', function (Blueprint $table) {
            $table->boolean('pending')->nullable(false)->default(false)->change();
        });

        Schema::table('members', function (Blueprint $table) {
            $table->renameColumn('pending', 'is_pending');
            $table->renameColumn('is_donator', 'is_donor');
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
            $table->string('is_pending')->nullable(true)->default(null)->change();
        });

        Schema::table('members', function (Blueprint $table) {
            $table->renameColumn('is_pending', 'pending');
            $table->renameColumn('is_donor', 'is_donator');
        });
    }
}
