<?php

namespace Proto\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Proto\Models\ActivityParticipation;

class ActivitySubscribedTo extends Mailable
{
    use Queueable, SerializesModels;

    public $activity;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(ActivityParticipation $participation, $help)
    {
        $this->activity = [
            'id' => $participation->activity->event->getPublicId(),
            'title' => $participation->activity->event->title,
            'name' => $participation->user->calling_name,
            'help' => $help
        ];
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
            ->subject('You have been signed up for ' . $this->activity['title'] . '.')
            ->view('emails.subscribeactivity');
    }
}
