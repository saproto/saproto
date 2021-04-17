<?php

use Illuminate\Database\Migrations\Migration;

class UpdateSessionsForLaravel52 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sessions', function ($table) {
            $table->integer('user_id')->nullable(true);
            $table->string('ip_address')->nullable(true);
            $table->text('user_agent');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sessions', function ($table) {
            $table->dropColumn('user_id');
            $table->dropColumn('ip_address');
            $table->dropColumn('user_agent');
        });
    }
}
