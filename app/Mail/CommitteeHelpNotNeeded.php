<?php

namespace Proto\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CommitteeHelpNotNeeded extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $help_title;
    public $committee_name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $help_title, $committee_name)
    {
        $this->user = $user;
        $this->help_title = $help_title;
        $this->committee_name = $committee_name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->from('board@proto.utwente.nl', 'S.A. Proto')
            ->subject('The activity ' . $this->help_title . ' doesn\'t need your help anymore.')
            ->view('emails.committeehelpnotneeded');
    }
}
