<?php

namespace App\Mail;

use App\Models\Email;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewManualEmail extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public Email $email, public User $user)
    {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address($this->email->sender_address.'@'.config('proto.emaildomain'), $this->email->sender_name),
            subject: $this->email->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return (new Content(
            view: 'emails.manualemail',
        ))->with([
            'body' => $this->email->parseBodyFor($this->user),
        ]);
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return $this->email->attachments->map(fn ($attachment) => Attachment::fromPath($attachment->generateLocalPath())->as($attachment->original_filename)->withMime($attachment->mime))->toArray();
    }
}