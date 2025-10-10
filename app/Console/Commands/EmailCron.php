<?php

namespace App\Console\Commands;

use App\Mail\ManualEmail;
use App\Models\Email;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;

class EmailCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'proto:emailcron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cronjob that sends all admin created e-mails';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @throws Exception
     */
    public function handle(): void
    {
        // Send admin created e-mails.
        $emails = Email::query()
            ->with('events')
            ->where('sent', false)
            ->where('ready', true)
            ->where('time', '<', Carbon::now()->timestamp)
            ->get();

        $this->info('There are '.$emails->count().' queued e-mails.');

        foreach ($emails as $email) {
            /** @var Email $email */
            $this->info('Sending e-mail <'.$email->subject.'>');
            $recipients = $email->recipients();

            $email->update([
                'sent' => true,
                'sent_to' => $recipients->count(),
                'ready' => false,
            ]);

            foreach ($recipients as $recipient) {
                Mail::to($recipient)
                    ->queue((new ManualEmail(
                        $email->sender_address.'@'.Config::string('proto.emaildomain'),
                        $email->sender_name,
                        $email->subject,
                        $email->parseBodyFor($recipient),
                        $email->getMedia(),
                        $email->destinationForBody(),
                        $recipient->id,
                        $email->events,
                        $email->id
                    )
                    )->onQueue('medium'));
            }

            $this->info('Sent to '.$recipients->count().' people.');
        }

        $this->info(($emails->count() > 0 ? 'All e-mails sent.' : 'No e-mails to be sent.'));
    }
}
