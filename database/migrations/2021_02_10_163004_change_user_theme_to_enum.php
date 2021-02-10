<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ChangeUserThemeToEnum extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $i=0;
        foreach(config('proto.themes') as $theme){
            DB::table('users')->where('theme', $theme)->update(['theme' => $i]);
            $i++;
        }

        Schema::table('users', function (Blueprint $table) {
            $table->integer('theme')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('theme')->change();
        });

        $i=0;
        foreach(config('proto.themes') as $theme){
            DB::table('users')->where('theme', $i)->update(['theme' => "assets/application-{$theme}.css"]);
            $i++;
        }
    }
}
