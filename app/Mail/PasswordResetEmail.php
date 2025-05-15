<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordResetEmail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public string $name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, public $token)
    {
        $this->name = $user->calling_name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('Your password reset request for S.A. Proto.')
            ->view('emails.password');
    }
}
