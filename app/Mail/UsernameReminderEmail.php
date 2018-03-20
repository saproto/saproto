<?php

namespace Proto\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Proto\Models\User;

class UsernameReminderEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $username;
    public $ismember;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->name = $user->calling_name;
        $this->ismember = $user->member !== null;
        $this->username = $this->ismember ? $user->member->proto_username : null;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('Your username for S.A. Proto.')
            ->view('emails.username');
    }
}
