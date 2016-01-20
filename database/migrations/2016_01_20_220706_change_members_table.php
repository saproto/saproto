<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('members', function ($table) {
            $table->string('proto_mail');
            $table->boolean('proto_mail_enabled');
            $table->enum('type', ['ORDINARY', 'ASSOCIATE', 'HONORARY', 'DONATOR']);
            $table->datetime('since');
            $table->datetime('till');
            $table->enum('fee_cycle', ['YEARLY', 'FULLTIME']);

            $table->date('birthdate');
            $table->tinyInteger('gender');
            $table->text('nationality');
            $table->text('phone');
            $table->text('website');
            $table->text('biography');

            $table->text('association_primary');

            $table->boolean('phone_visible');
            $table->boolean('address_visible');
            $table->boolean('receive_newsletter');
            $table->boolean('receive_sms');

            $table->dropColumn('utwente_username');
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
