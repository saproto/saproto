<?php

namespace App\Console\Commands;

use App\Mail\VerifyPersonalDetails;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class VerifyPersonalDetailsEmailCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'proto:verifydetailscron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cronjob that sends the bi-yearly e-mail to remind users to keep their personal data up to date.';

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
    public function handle(): void
    {
        $month = Str::padLeft(Carbon::now()->addMonth()->month, 2, '0');

        $users = User::query()->where('created_at', 'like', sprintf('____-%s-__ __:__:__', $month < 10 ? '0'.$month : $month))->get();

        foreach ($users as $user) {
            Mail::to($user)->queue((new VerifyPersonalDetails($user))->onQueue('low'));
        }

        $this->info(sprintf('Sent reminder e-mail to %d members.', $users->count()));
    }
}
