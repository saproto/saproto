<?php

namespace Proto\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ManualEmail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $from;
    public $subject;
    public $body;
    public $submitted_attachments;
    public $destination;
    public $user_id;
    public $event_name;
    public $email_id;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($from, $subject, $body, $attachments, $destination, $user_id, $event_name, $email_id)
    {
        $this->from = $from;
        $this->subject = $subject;
        $this->body = $body;
        $this->submitted_attachments = $attachments;
        $this->destination = $destination;
        $this->user_id = $user_id;
        $this->event_name = $event_name;
        $this->email_id = $email_id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $mail = $this->view('emails.manualemail')
            ->from($this->from['email'], $this->from['name'])
            ->subject($this->subject);
        foreach ($this->submitted_attachments as $attachment) {
            $options = [
                'as' => $attachment->original_filename,
                'mime' => $attachment->mime,
            ];
            $mail->attach($attachment->generateLocalPath(), $options);
        }
        return $mail;
    }
}
