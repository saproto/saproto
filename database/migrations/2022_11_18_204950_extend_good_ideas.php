<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ExtendGoodIdeas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('good_ideas', function (Blueprint $table) {
            $table->bigInteger('idea_category_id')->after('user_id')->nullable();
            $table->text('reply')->after('idea')->nullable();
            $table->softDeletes();
        });

        Schema::create('good_idea_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('good_ideas', function (Blueprint $table) {
            $table->dropColumn('reply');
            $table->dropColumn('idea_category_id');
            $table->dropSoftDeletes();
        });

        Schema::drop('good_idea_categories');
    }
}