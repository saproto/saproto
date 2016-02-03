<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAllownullables2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('members', function ($table) {
            $table->dropColumn('association_primary');
            $table->boolean('primary_member');
            $table->dropColumn('proto_mail_enabled');

            $table->dateTime('till')->nullable();
            $table->string('proto_mail')->nullable();
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
