<?php

namespace Proto\Console\Commands;

use Illuminate\Console\Command;
use Mail;
use Proto\Mail\ReviewFeedbackMail;
use Proto\Models\FeedbackCategory;

class ReviewFeedbackCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'proto:reviewfeedbackcron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send the email to the reviewer of a feedback category if new feedback needs reviewed';

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

        foreach(FeedbackCategory::query()->where('review', true)->whereNotNull('reviewer_id')->get() as $category){
            $unreviewed = $category->feedback()->where('reviewed', false)->where('updated_at', '>=', \Carbon::now()->subDay()->timestamp)->get();
            if(count($unreviewed)) {
                $this->info("Sending a review reminder mail for $category->title");
                Mail::queue((new ReviewFeedbackMail($category, $unreviewed))->onQueue('low'));
            }else{
                $this->info('No new reviews which need to be checked today!');
            }
        }
    }
}
