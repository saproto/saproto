<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMemberOnlyToMenuitems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('menuitems', function ($table) {
            $table->boolean('is_member_only');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('menuitems', function ($table) {
            $table->dropColumn('is_member_only');
        });
    }
}
