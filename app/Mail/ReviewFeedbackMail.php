<?php

namespace App\Mail;

use App\Models\Feedback;
use App\Models\FeedbackCategory;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class ReviewFeedbackMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * Create a new message instance.
     * @param Collection<int, Feedback> $feedback
     * @return void
     */
    public function __construct(public FeedbackCategory $category, public Collection $feedback) {}

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): static
    {
        return $this
            ->to($this->category->reviewer->email)
            ->subject('Review feedback for: '.$this->category->title.'!')
            ->view('emails.feedbackreviewreminder', ['category' => $this->category, 'unreviewed' => $this->feedback, 'calling_name' => $this->category->reviewer->first()->calling_name]);
    }
}
