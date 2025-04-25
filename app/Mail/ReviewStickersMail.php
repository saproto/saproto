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
    /** @param Collection<Sticker> $reported */
    public function __construct(public Collection $reported) {}

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->to('board@'.Config::string('proto.emaildomain'), 'Board of S.A. Proto')
            ->subject('There are new stickers reported!')
            ->view('emails.stickerreviewreminder', ['reported' => $this->reported]);
    }
}
