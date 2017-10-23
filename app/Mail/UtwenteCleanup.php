<?php

namespace Proto\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UtwenteCleanup extends Mailable
{
    use Queueable, SerializesModels;

    public $accounts;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($accounts)
    {
        $this->accounts = $accounts;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->to('secretary@' . config('proto.emaildomain'), 'S.A. Proto Secretary')
            ->cc('sysadmin@' . config('proto.emaildomain'), 'S.A. Proto System Admins')
            ->subject('UTwente Account Clean-Up')
            ->view('emails.utwente_cleanup');
    }
}
