<?php

namespace Proto\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Proto\Models\User;
use Proto\Models\Withdrawal;

class OmnomcomFailedWithdrawalNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $withdrawal;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, Withdrawal $withdrawal)
    {
        $this->user = $user;
        $this->withdrawal = $withdrawal;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->from('treasurer@' . config('proto.emaildomain'), config('proto.treasurer'))
            ->subject('S.A. Proto Failed Withdrawal Notification')
            ->view('emails.omnomcom.failedwithdrawalnotification');
    }
}
