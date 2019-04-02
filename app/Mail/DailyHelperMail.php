<?php

namespace Proto\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class DailyHelperMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $help;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $help)
    {
        $this->user = $user;
        $this->help = $help;
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
            ->subject('The activity ' . $this->help->activity->event->title . ' needs your help.')
            ->view('emails.dailyhelpermail');
    }
}