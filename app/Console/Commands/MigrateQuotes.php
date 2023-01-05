<?php

namespace Proto\Console\Commands;

use Illuminate\Console\Command;
use Proto\Models\Feedback;
use Proto\Models\FeedbackCategory;
use Proto\Models\FeedbackVote;
use Proto\Models\Quote;

class MigrateQuotes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'proto:migratequotes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $quoteCategory=new FeedbackCategory([
            'title'=>'quotes',
            'url'=>'quotes',
            'review'=>false
        ]);
        $quoteCategory->save();

        foreach(Quote::all() as $quote){
            $new=new Feedback([
                'user_id'=>$quote->user->id,
                'feedback_category_id'=>$quoteCategory->id,
                'feedback'=>$quote->quote,
                'reviewed'=>true,
            ]);
            $new->save();
            foreach($quote->quoteLike() as $like){
                $newLike=new FeedbackVote([
                    'user_id'=>$like->user_id,
                    'feedback_id'=>$new->id,
                    'vote'=>1,
                ]);
                $newLike->save();
            }
        }
    }
}
