<?php

namespace App\Console\Commands;

use App\Mail\TestMail;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

#[Description('This command sends a test e-mail message to see if stuff works.')]
#[Signature('proto:testmail')]
class TestEmail extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $email = $this->ask('What is the destination for this e-mail?');

        Mail::to($email)->queue((new TestMail)->onQueue('high'));

        $this->info('Sent!');
    }
}
