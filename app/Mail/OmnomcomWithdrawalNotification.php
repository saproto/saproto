<?php

namespace App\Mail;

use App\Models\User;
use App\Models\Withdrawal;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;

class OmnomcomWithdrawalNotification extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * @var User
     */
    public $user;

    /**
     * @var Withdrawal
     */
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
            ->from('treasurer@'.Config::string('proto.emaildomain'), Config::string('proto.treasurer'))
            ->subject('S.A. Proto Withdrawal Announcement for '.Carbon::parse($this->withdrawal->date)->format('d-m-Y'))
            ->view('emails.omnomcom.withdrawalnotification');
    }
}
