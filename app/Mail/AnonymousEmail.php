<?php

namespace App\Mail;

use App\Models\Committee;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AnonymousEmail extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(public Committee $committee, public string $message_content, public string $hash) {}

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('Anonymous e-mail for the '.$this->committee->name.'.')
            ->view('emails.anonymous');
    }
}
