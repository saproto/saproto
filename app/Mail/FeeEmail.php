<?php

namespace Proto\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FeeEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $fee;
    public $remitted_reason;
    public $fee_amount;
    public $user;

    public function __construct($user, $fee, $fee_amount, $remitted_reason)
    {
        $this->user = $user;
        $this->fee = $fee;
        $this->fee_amount = $fee_amount;
        $this->remitted_reason = $remitted_reason;
    }

    public function build()
    {
        return $this
            ->from('treasurer@proto.utwente.nl', config('proto.treasurer'))
            ->subject('Information on your membership fee for S.A. Proto')
            ->view('emails.fee_for_users');
    }
}
