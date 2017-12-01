<?php

namespace Proto\Console\Commands;

use Illuminate\Console\Command;

use Proto\Models\Member;

class CountPrimaryMembers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'proto:countprimarymembers {--s|show : Also show a list of all primary members}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Count the number of primary members Proto has at this time, using the latest UT data.';

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
     * @return mixed
     */
    public function handle()
    {
        // Get a list of all CreaTe students.
        $ldap_students = json_decode(file_get_contents(config('app-proto.utwente-ldap-hook') . '?filter=department=*B-CREA*'));

        $names = [];
        $emails = [];
        $usernames = [];

        foreach ($ldap_students as $student) {
            $names[] = strtolower($student->givenname[0] . ' ' . $student->sn[0]);
            $emails[] = strtolower($student->mail[0]);
            $usernames[] = $student->uid[0];
        }

        $print_members = $this->option('show');

        $count = 0;

        // Loop over all members and determine if they are studying CreaTe.
        foreach (Member::all() as $member) {

            if (
                in_array(strtolower($member->user->email), $emails) ||
                in_array($member->user->utwente_username, $usernames) ||
                in_array(strtolower($member->user->name), $names)
            ) {
                if ($print_members) {
                    $utwente_username = $member->user->utwente_username !== null ? $member->user->utwente_username : 'no utwente username';
                    if (substr($member->user->email, -10) == 'utwente.nl') {
                        $this->info(sprintf('%s - %s (%s)', $member->user->name, $member->user->email, $utwente_username));
                    } else {
                        $this->info(sprintf('%s (%s)', $member->user->name, $utwente_username));
                    }
                }
                $count++;
            }

        }

        $this->info(sprintf('I count %d primary members.', $count));

    }
}
