<?php

namespace Proto\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Proto\Models\Feedback;
use Proto\Models\User;

class GoodIdeaReplyEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $idea;
    public $user;
    public $reply;

    /**
     * Create a new message instance.
     *
     * @param Feedback $idea
     * @param User $user
     * @param $reply
     */
    public function __construct(Feedback $idea, User $user, $reply)
    {
        $this->idea = $idea;
        $this->user = $user;
        $this->reply = $reply;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->from('board@' . config('proto.emaildomain'), 'Board of S.A. Proto')
            ->subject('Reply to your good idea!')
            ->view('emails.goodideareply');
    }
}