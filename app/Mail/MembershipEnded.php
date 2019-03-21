<?php

namespace Proto\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Proto\Models\User;
use Proto\Models\EmailList;

class MembershipEnded extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $lists;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
        $this->lists = $this->getSubscriptionList();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->from('secretary@proto.utwente.nl', config('proto.secretary') . ' (Secretary)')
            ->subject('Termination of your membership of Study Association Proto')
            ->view('emails.membershipend');
    }

    public function getSubscriptionList()
    {
        $footer = [];
        $lists = $this->user->lists;
        foreach ($lists as $list) {
            $footer[] = sprintf('<li>%s (<a href="%s">Unsubscribe</a>)</li>', $list->name, route('unsubscribefromlist', ['hash' => EmailList::generateUnsubscribeHash($this->user->id, $list->id)]));
        }
        return implode('', $footer);
    }
}
