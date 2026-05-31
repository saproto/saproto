<?php

namespace App\Console\Commands;

use App\Models\Email;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Date;

#[Signature('proto:queue-wrapped-email')]
#[Description('Queue the yearly information email that wrapped is live!')]
class QueueWrappedEmail extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $year = Date::now()->year;
        $email = new Email([
            'description' => "Proto Wrapped $year is live",
            'subject' => "Proto Wrapped $year is live!",
            'body' => "Dear \$calling_name, \n\n We just entered the 12th and final month of the year! \nMaking this the perfect time to reflect over your past year at Proto. \nAnd what better way to do this, then with some good old statistics? \n\n Which snacks have you consumed most? \nWhich songs did you put into ProTube? \nAnd ofcourse, most importantly of all, which cookie monster describes your past year the best? \n\n Click [here](https://www.proto.utwente.nl/wrapped) to find out now!",
            'sender_name' => 'The HYTTIOAOAc',
            'sender_address' => 'haveyoutriedturningitoffandonagain',
            'to_member' => true,
            'ready' => true,
            'time' => Date::now()->addMinutes(5)->timestamp,
        ]);
        $email->save();
    }
}
