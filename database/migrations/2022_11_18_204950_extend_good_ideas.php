<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ExtendGoodIdeas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('good_idea_votes', 'feedback_votes');
        Schema::table('feedback_votes', function (Blueprint $table) {
            $table->renameColumn('good_idea_id', 'feedback_id');
        });

        Schema::rename('good_ideas', 'feedback');
        Schema::table('feedback', function (Blueprint $table) {
            $table->renameColumn('idea', 'feedback');
            $table->bigInteger('feedback_category_id')->after('user_id')->default(1);
            $table->boolean('reviewed')->after('idea')->default(false);
            $table->boolean('accepted')->after('reviewed')->nullable();
            $table->text('reply')->after('accepted')->nullable();
            $table->softDeletes();
        });

        Schema::create('feedback_categories', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('url');
            $table->boolean('review');
            $table->integer('reviewer_id')->nullable();
            $table->timestamps();
        });

        $goodideas = new \Proto\Models\FeedbackCategory([
           'title'=>'Good ideas',
            'url'=>'goodideas',
            'review'=>false,
        ]);
        $goodideas->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename('feedback_votes', 'good_idea_votes');
        Schema::table('good_idea_votes', function (Blueprint $table) {
            $table->renameColumn('feedback_id', 'good_idea_id');
        });

        Schema::rename('feedback', 'good_ideas');
        Schema::table('good_ideas', function (Blueprint $table) {
            $table->renameColumn('feedback', 'idea');
            $table->dropIfExists('reviewed');
            $table->dropIfExists('accepted');
            $table->dropIfExists('reply');
            $table->dropIfExists('feedback_category_id');
            $table->dropSoftDeletes();
        });

        Schema::drop('feedback_categories');
    }
}