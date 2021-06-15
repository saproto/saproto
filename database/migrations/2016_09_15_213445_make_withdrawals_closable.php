<?php

use Illuminate\Database\Migrations\Migration;

class MakeWithdrawalsClosable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('withdrawals', function ($table) {
            $table->boolean('closed')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('withdrawals', function ($table) {
            $table->dropColumn('closed');
        });
    }
}
