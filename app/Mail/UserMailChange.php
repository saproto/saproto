<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;

class UserMailChange extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * Create a new message instance.
     *
     * @param array{
     * name: string,
     * ip: string|null
     * } $changer
     * @param  array<string, mixed>  $email
     * @return void
     */
    public function __construct(public User $user, public array $changer, public array $email) {}

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): static
    {
        return $this
            ->from('security@'.Config::string('proto.emaildomain'), 'Have You Tried Turning It Off And On Again committee')
            ->subject('Your e-mail address for S.A. Proto has been changed.')
            ->view('emails.emailchange');
    }
}
