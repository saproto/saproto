<?php

namespace App\Mail;

use App\Models\Member;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Date;

class MembershipEndedForBoard extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * Create a new message instance.
     *
     * @param  Member[]  $deleted_memberships
     * @return void
     */
    public function __construct(public array $deleted_memberships) {}

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->to('board@proto.utwente.nl', 'S.A. Proto Membership Terminations')
            ->subject('Member ship automatically ended for '.count($this->deleted_memberships).' members! '.Date::now()->format('d-m-Y'))
            ->view('emails.membershipsendedforboard');
    }
}
