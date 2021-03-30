<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUrlToAchievementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('achievement', function(Blueprint $table) {
            $table->boolean('has_page')->after('tier');
            $table->string('page_name')->nullable()->unique()->after('has_page');
            $table->text('page_content')->nullable()->after('page_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('achievement', function (Blueprint $table) {
            $table->dropColumn('has_page');
            $table->dropColumn('page_name');
            $table->dropColumn('page_content');
        });
    }
}
