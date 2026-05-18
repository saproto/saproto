<?php

namespace App\Mail;

use App\Models\Activity;
use App\Models\Sticker;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;

class CloseActivitiesReminder extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    /** @param \Illuminate\Database\Eloquent\Collection<int, Activity> $unclosed */
    public function __construct(public Collection $unclosed) {}

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): static
    {
        $amount = $this->unclosed->count();

        return $this
            ->to('treasurer@'.Config::string('proto.emaildomain'), 'Treasurer of S.A. Proto')
            ->subject("There are {$amount} unclosed activities!")
            ->view('emails.closeactivitiesreminder', ['activities' => $this->unclosed]);
    }
}
