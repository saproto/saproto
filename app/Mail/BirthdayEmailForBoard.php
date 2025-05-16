<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BirthdayEmailForBoard extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * Create a new message instance.
     *
     * @param  array<int, array{id: string|int, name: string, age: int}>  $users
     * @return void
     */
    public function __construct(public array $users) {}

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): static
    {
        return $this
            ->subject('Birthdays of today!')
            ->view('emails.users.birthdaylist');
    }
}
