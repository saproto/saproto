<?php

namespace Proto\Console\Commands;

use Illuminate\Console\Command;

use Proto\Mail\BirthdayEmail;
use Proto\Mail\BirthdayEmailForBoard;

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

            $adminoverview = [];

            foreach ($users as $user) {

                $adminoverview[] = [
                    'id' => $user->getPublicId(),
                    'name' => $user->name,
                    'age' => $user->age()
                ];

                Mail::to($user)->queue((new BirthdayEmail($user))->onQueue('medium'));

            }

            Mail::to('board@' . config('proto.emaildomain'))->queue((new BirthdayEmailForBoard($adminoverview))->onQueue('low'));

            $this->info("Done!");

        } else {

            $this->info("There are no jarige joppen today.");

        }

    }

}
