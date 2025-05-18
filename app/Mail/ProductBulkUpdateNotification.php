<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;

class ProductBulkUpdateNotification extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(public User $user, public string $log) {}

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): static
    {
        return $this
            ->to('omnomcom@'.Config::string('proto.emaildomain'), 'OmNomCom Committee')
            ->to('treasurer@'.Config::string('proto.emaildomain'), Config::string('proto.treasurer'))
            ->subject('OmNomCom bulk product stock update.')
            ->view('emails.omnomcom.bulkproductupdate');
    }
}
