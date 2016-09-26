<?php

namespace Proto\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

use Proto\Models\EmailList;
use Proto\Models\Event;

use Mail;
use Proto\Models\User;

class BirthdayCron extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'proto:birthdaycron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cronjob that sends the daily birthday e-mails.';

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
     */
    public function handle()
    {

        $users = User::where('birthdate', 'LIKE', '%-' . date('m-d'))->has('member')->get();

        if ($users->count() > 0) {

            $this->info('Sending birthday notification to ' . $users->count() . ' people.');

            foreach ($users as $user) {

                $name = $user->name;
                $email = $user->email;

                Mail::queue('emails.users.birthdayemail', ['user' => $user], function ($message) use ($name, $email) {
                    $message
                        ->to($email, $name)
                        ->from('internal@' . config('proto.emaildomain'), config('proto.internal'))
                        ->subject('Happy birthday!');
                });

            }

            Mail::send('emails.users.birthdaylist', ['users' => $users], function ($message) {
                $message
                    ->to('board@' . config('proto.emaildomain'), 'S.A. Proto Board')
                    ->subject('Birthdays of today!');
            });

            $this->info("Done!");

        } else {

            $this->info("There are no jarige joppen today.");

        }

    }

}
