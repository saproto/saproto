<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ExtendGoodIdeas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('good_ideas', function (Blueprint $table) {
            $table->text('reply')->after('idea')->nullable();
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
            $table->dropColumn('reply');
            $table->dropSoftDeletes();
        });
    }
}
