<?php

namespace Proto\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Proto\Models\Feedback;
use Proto\Models\User;

class FeedbackReplyEmail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $feedback;
    public $user;
    public $reply;
    public $accepted;

    /**
     * Create a new message instance.
     *
     * @param Feedback $feedback
     * @param User $user
     * @param $reply
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
            ->subject(`Answer on your {{$this->feedback->category->title}}`)
            ->view('emails.feedbackreply');
    }
}