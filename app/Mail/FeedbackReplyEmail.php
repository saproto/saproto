<?php

namespace App\Mail;

use App\Models\Feedback;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FeedbackReplyEmail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public Feedback $feedback;

    public User $user;

    public String $reply;

    public bool $accepted;

    /**
     * Create a new message instance.
     */
    public function __construct(Feedback $feedback, User $user, $reply, bool $accepted)
    {
        $this->feedback = $feedback;
        $this->user = $user;
        $this->reply = $reply;
        $this->accepted = $accepted;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->from('board@'.config('proto.emaildomain'), 'Board of S.A. Proto')
            ->subject('Answer on your '.$this->feedback->category->title)
            ->view('emails.feedbackreply');
    }
}
