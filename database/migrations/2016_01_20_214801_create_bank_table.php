<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBankTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bankaccounts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->text('iban');
            $table->text('bic');
            $table->text('machtigingid');
            $table->enum('withdrawal_type', ['RCUR', 'FRST']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
