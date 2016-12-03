<?php

namespace Proto\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

use Proto\Models\StorageEntry;
use Proto\Models\User;
use Proto\Models\Member;

use Mail;

class FillEmptyProtoUsernames extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'proto:emptyusernames';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fill empty Proto usernames.';

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

        foreach (Member::where('proto_username', '=', '')->withTrashed()->get() as $member) {

            if ($member->user) {
                $name = explode(" ", $member->user->name);
                $aliasbase = strtolower(substr($name[0], 0, 1) . '.' . str_replace(' ', '', implode("", array_slice($name, 1))));
            } else {
                $aliasbase = 'unknown-user';
            }

            $alias = $aliasbase;
            $i = 0;

            while (Member::where('proto_username', $alias)->withTrashed()->count() > 0) {
                $i++;
                $alias = $aliasbase . '-' . $i;
            }

            $member->proto_username = $alias;
            $member->save();

        }

    }

}
