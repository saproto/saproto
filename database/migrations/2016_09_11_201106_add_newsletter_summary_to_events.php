<?php

use Illuminate\Database\Migrations\Migration;

class AddNewsletterSummaryToEvents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events', function ($table) {
            $table->text('summary')->nullable()->default(null);
        });
        Schema::table('users', function ($table) {
            $table->dropColumn('receive_newsletter');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('events', function ($table) {
            $table->dropColumn('summary');
        });
        Schema::table('users', function ($table) {
            $table->boolean('receive_newsletter')->default(false);
        });
    }
}
