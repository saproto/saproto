<?php

use Illuminate\Database\Migrations\Migration;

class RemovePrintedFileColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('files', function ($table) {
            $table->dropColumn('is_print_file');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('files', function ($table) {
            $table->boolean('is_print_file')->default(false);
        });
    }
}
