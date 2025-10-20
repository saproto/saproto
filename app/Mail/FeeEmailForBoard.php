<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Date;

class FeeEmailForBoard extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * Create a new message instance.
     *
     * @param  $charged_fees  object{count: int, regular: string[], reduced: string[], remitted: string[]}
     * @return void
     */
    public function __construct(public object $charged_fees) {}

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): static
    {
        return $this
            ->to('payments@proto.utwente.nl', 'S.A. Proto Payments Update')
            ->subject('Membership Fee Cron Update for '.Date::now()->format('d-m-Y').'. ('.$this->charged_fees->count.' transactions)')
            ->view('emails.fee');
    }
}
