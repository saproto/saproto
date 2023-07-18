<?php

use App\Models\Feedback;
use App\Models\FeedbackCategory;
use App\Models\FeedbackVote;
use App\Models\GoodIdea;
use App\Models\Quote;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFeedbackFunctionality extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feedback_votes', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('feedback_id');
            $table->integer('vote');
            $table->timestamps();
        });

        Schema::create('feedback', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->bigInteger('feedback_category_id')->default(1);
            $table->text('feedback');
            $table->boolean('reviewed')->default(false);
            $table->boolean('accepted')->nullable();
            $table->text('reply')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('feedback_categories', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('url');
            $table->boolean('review');
            $table->integer('reviewer_id')->nullable();
            $table->boolean('can_reply')->default(true);
            $table->timestamps();
        });

        $goodideaCategory = new FeedbackCategory([
            'title' => 'Good Ideas',
            'url' => 'goodideas',
            'review' => false,
            'can_reply' => true,
        ]);
        $goodideaCategory->save();

        if (class_exists('GoodIdea')) {
            foreach (GoodIdea::all() as $goodidea) {
                $new = new Feedback([
                    'user_id' => $goodidea->user->id,
                    'feedback_category_id' => $goodidea->id,
                    'feedback' => $goodidea->quote,
                    'reviewed' => true,
                    'created_at' => $goodidea->created_at,
                ]);
                $new->save();
                foreach ($goodidea->quoteLike() as $like) {
                    $newLike = new FeedbackVote([
                        'user_id' => $like->user_id,
                        'feedback_id' => $new->id,
                        'vote' => 1,
                        'created_at' => $goodidea->created_at,
                    ]);
                    $newLike->save();
                }
            }
        }

        $quoteCategory = new FeedbackCategory([
            'title' => 'Quotes',
            'url' => 'quotes',
            'review' => false,
            'can_reply' => false,
        ]);
        $quoteCategory->save();

        if (class_exists('Quote')) {
            foreach (Quote::all() as $quote) {
                $new = new Feedback([
                    'user_id' => $quote->user->id,
                    'feedback_category_id' => $quoteCategory->id,
                    'feedback' => $quote->quote,
                    'reviewed' => true,
                    'created_at' => $quote->created_at,
                ]);
                $new->save();
                foreach ($quote->quoteLike() as $like) {
                    $newLike = new FeedbackVote([
                        'user_id' => $like->user_id,
                        'feedback_id' => $new->id,
                        'vote' => 1,
                        'created_at' => $quote->created_at,
                    ]);
                    $newLike->save();
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('feedback');
        Schema::drop('feedback_votes');
        Schema::drop('feedback_categories');
    }
}
