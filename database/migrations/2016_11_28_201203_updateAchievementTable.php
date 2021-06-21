<?php

use Illuminate\Database\Migrations\Migration;

class UpdateAchievementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('achievement', function ($table) {
            $table->dropColumn('img_file_id');
            $table->text('fa_icon')->nullable()->after('desc');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('achievement', function ($table) {
            $table->dropColumn('fa_icon');
            $table->integer('img_file_id')->nullable();
        });
    }
}
