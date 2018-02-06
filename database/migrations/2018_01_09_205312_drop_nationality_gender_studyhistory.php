<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropNationalityGenderStudyhistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('gender');
            $table->dropColumn('nationality');
        });
        Schema::drop('studies_users');
        Schema::drop('pages_studies');
        Schema::drop('studies');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('gender')->nullable()->default(null);
            $table->string('nationality')->nullable()->default(null);
        });

        Schema::create('studies_users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('study_id');
            $table->integer('user_id');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('pages_studies', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('page_id');
            $table->integer('study_id');
            $table->integer('quartile');
            $table->timestamps();
        });

        Schema::create('studies', function (Blueprint $table) {
            $table->increments('id');
            $table->text('name')->nullable(false);
            $table->text('faculty')->nullable(false);
            $table->timestamps();
            $table->enum('type', ['BSc', 'MSc', 'Minor', 'Other'])->default('BSc');
            $table->boolean('utwente')->default(true);
        });
    }
}
