<?php

namespace Proto\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Proto\Models\FeedbackCategory;

class ReviewFeedbackMail extends Mailable
{
    use Queueable, SerializesModels;

    public $category;
    public $feedback;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(FeedbackCategory $category, $feedback)
    {
        $this->feedback=$feedback;
        $this->$category=$this->category->title;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('Review feedback for: '.$this->category->title.'!')
            ->view('emails.feedbackreviewreminder', ['category'=>$this->category ,'unreviewed'=>$this->feedback]);
    }
}
