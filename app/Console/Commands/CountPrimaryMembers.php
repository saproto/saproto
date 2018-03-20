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
    protected $signature = 'proto:countprimarymembers {--show : Also show a list of all primary members} {--all : Also include secondary members}';

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
        $show_all_members = $this->option('all');

        $count_primary = 0;
        $count_secondary = 0;

        // Loop over all members and determine if they are studying CreaTe.
        foreach (Member::all() as $member) {

            $is_create_student = in_array(strtolower($member->user->email), $emails) ||
                in_array($member->user->utwente_username, $usernames) ||
                in_array(strtolower($member->user->name), $names);

            $has_ut_mail = substr($member->user->email, -10) == 'utwente.nl';

            $is_ut = $is_create_student || $has_ut_mail || $member->user->utwente_username !== null;

            $display_fields = (object)[
                'status' => $is_create_student ? '[P]' : '   ',
                'name' => $is_ut ? $member->user->name : '***',
                'email' => $has_ut_mail ? $member->user->email : '***@***.**',
                'ut_account' => $member->user->utwente_username ? $member->user->utwente_username : 'n/a'
            ];

            if ($is_create_student) {
                $count_primary++;
            } else {
                $count_secondary++;
            }

            if ($print_members && $show_all_members || $print_members && $is_create_student) {
                $this->info(sprintf('%s %s - %s (%s)', $display_fields->status, $display_fields->name, $display_fields->email, $display_fields->ut_account));
            }

        }

        $this->info(sprintf('Total count: %d primary, %d secondary members (total: %d).', $count_primary, $count_secondary, $count_primary + $count_secondary));

    }
}
