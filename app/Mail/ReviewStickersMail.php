<?php

namespace App\Mail;

use App\Models\Sticker;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;

class ReviewStickersMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    /** @param Collection<int, Sticker> $reported */
    public function __construct(public Collection $reported) {}

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): static
    {
        $amount = $this->reported->count();

        return $this
            ->to('board@'.Config::string('proto.emaildomain'), 'Board of S.A. Proto')
            ->subject("There are {$amount} reported stickers awaiting review!")
            ->view('emails.stickerreviewreminder', ['reported' => $this->reported->load('reporter')]);
    }
}
