<?php

namespace Proto\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Proto\Models\User;

class Newsletter extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $list;

    public function __construct(User $user, $list)
    {
        $this->user = $user;
        $this->list = $list;
    }

    public function build()
    {
        return $this
            ->from('internal@' . config('proto.emaildomain'), config('proto.internal'))
            ->subject('S.A. Proto Weekly Newsletter (Week ' . date("W") . ')')
            ->view('emails.newsletter');
    }
}
