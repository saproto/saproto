<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameProtomailToProtousername extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('members', function ($table) {
            $table->text('proto_mail')->nullable(false)->change();
            $table->renameColumn('proto_mail', 'proto_username');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('members', function ($table) {
            $table->text('proto_username')->nullable(true)->change();
            $table->renameColumn('proto_username', 'proto_mail');
        });
    }
}
