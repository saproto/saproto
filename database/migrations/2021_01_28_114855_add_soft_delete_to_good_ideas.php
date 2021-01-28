<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSoftDeleteToGoodIdeas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('good_ideas', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('good_idea_votes', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('good_ideas', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        Schema::table('good_idea_votes', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
}
