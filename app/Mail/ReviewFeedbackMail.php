<?php

namespace App\Mail;

use App\Models\FeedbackCategory;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReviewFeedbackMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public FeedbackCategory $category;

    public $feedback;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(FeedbackCategory $category, $feedback)
    {
        $this->feedback = $feedback;
        $this->category = $category;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->to($this->category->reviewer->email)
            ->subject('Review feedback for: '.$this->category->title.'!')
            ->view('emails.feedbackreviewreminder', ['category' => $this->category, 'unreviewed' => $this->feedback, 'calling_name' => $this->category->reviewer->first()->calling_name]);
    }
}
