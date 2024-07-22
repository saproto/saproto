<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProductBulkUpdateNotification extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * @var User
     */
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, public $log)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->to('omnomcom@'.config('proto.emaildomain'), 'OmNomCom Committee')
            ->to('treasurer@'.config('proto.emaildomain'), config('proto.treasurer'))
            ->subject('OmNomCom bulk product stock update.')
            ->view('emails.omnomcom.bulkproductupdate');
    }
}
