<?php

namespace App\Mail;

use App\Models\EmailList;
use App\Models\Event;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;

class Newsletter extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * @param  Collection<int, Event>  $events
     */
    public function __construct(public User $user, public EmailList $list, public string $text, public Collection $events, public string $image_url)
    {
        //
    }

    public function build(): Newsletter
    {
        return $this
            ->from('internal@'.Config::string('proto.emaildomain'), Config::string('proto.internal'))
            ->subject('S.A. Proto Weekly Newsletter (Week '.Carbon::now()->format('W').')')
            ->view('emails.newsletter');
    }
}
