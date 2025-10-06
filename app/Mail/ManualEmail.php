<?php

namespace App\Mail;

use App\Models\Event;
use App\Models\StorageEntry;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ManualEmail extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * Create a new message instance.
     *
     * @param  Collection<int, Event>  $events
     * @param  Collection<int, Media>  $submitted_attachments
     * @return void
     */
    public function __construct(public string $sender_address, public string $sender_name, public string $email_subject, public string $body, public Collection $submitted_attachments, public string $destination, public int $user_id, public Collection $events, public int $email_id) {}

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): static
    {
        $mail = $this->view('emails.manualemail')
            ->from($this->sender_address, $this->sender_name)
            ->subject($this->email_subject);
        foreach ($this->submitted_attachments as $attachment) {
            $mail->attach($attachment);
        }

        return $mail;
    }
}
