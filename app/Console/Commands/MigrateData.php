<?php

namespace Proto\Console\Commands;

use Illuminate\Console\Command;

use DB;

use Proto\Models\Activity;
use Proto\Models\ActivityParticipation;
use Proto\Models\Address;
use Proto\Models\Bank;
use Proto\Models\Committee;
use Proto\Models\CommitteeMembership;
use Proto\Models\Event;
use Proto\Models\HelpingCommittee;
use Proto\Models\Member;
use Proto\Models\Quote;
use Proto\Models\Study;
use Proto\Models\StudyEntry;
use Proto\Models\User;

class MigrateData extends Command
{

    private $legacydb;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'proto:migrate {--no-confirmation : Skips the confirmation questions.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command migrates the old datebase to the new one.';

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
        if ($this->option('no-confirmation') != null || ($this->confirm("Would you like to migrate data from the old website?") && $this->confirm("Are you sure? This will overwrite all data in your database!"))) {

            $this->info('Preparing databases...');

            // We open the database connection.
            $this->legacydb = mysqli_connect(getenv('OLD_DB_HOST'), getenv('OLD_DB_USERNAME'), getenv('OLD_DB_PASSWORD'));

            DB::statement("SET foreign_key_checks=0");

            $this->info('Starting migration. This can take a while!');

            // Migration of users, members, studies, bank account, address.

            User::truncate();
            Member::truncate();
            Address::truncate();
            Study::truncate();
            StudyEntry::truncate();
            Bank::truncate();

            $this->legacydb->select_db("admin_members");
            $membersquery = $this->legacydb->query("SELECT * FROM members");

            while ($member = $membersquery->fetch_assoc()) {

                // Create user.
                $user = User::create([
                    'id' => $member['member_id'],
                    'email' => $member['contact_email'],
                    'password' => "correct horse battery staple",
                    'utwente_username' => ($member['utwente_relation'] == 1 ? $member['utwente_username'] : null),
                    'proto_username' => $member['proto_username'],
                    'name_first' => $member['name_first'],
                    'name_last' => $member['name_last'],
                    'name_initials' => $member['name_initials'],
                    'birthdate' => $member['person_birthdate'],
                    'gender' => $member['person_gender'],
                    'nationality' => $member['person_nationality'],
                    'phone' => ($member['contact_phone'] != '' ? str_replace(' ', '', $member['contact_phone']) : null),
                    'website' => ($member['profile_website'] != '' ? $member['profile_website'] : null),
                    'biography' => ($member['profile_biography'] != '' ? $member['profile_biography'] : null),
                    'phone_visible' => $member['privacy_phone_visible'],
                    'address_visible' => $member['privacy_address_visible'],
                    'receive_newsletter' => $member['privacy_receive_newsletter'],
                    'receive_sms' => $member['privacy_receive_sms'],
                    'created_at' => $member['member_since']
                ]);
                if ($user->proto_username == 'legacy') {
                    $user->id = 0;
                }
                if ($user->id == 94) {
                    $user->tfa_yubikey_identity = 'ccccccetjeel';
                }
                $user->save();

                if (strtotime($member['member_till']) > date('U')) {
                    $m = Member::create([
                        'is_lifelong' => ($member['fee_cycle'] == 'FULLTIME'),
                        'is_honorary' => ($member['member_type'] == 'HONORARY'),
                        'is_donator' => ($member['member_type'] == 'DONATOR'),
                        'is_associate' => ($member['association_primary'] != null),
                        'since' => strtotime($member['member_since']),
                        'till' => ($member['member_till'] == '2099-01-01' ? null : strtotime($member['member_till'])),
                        'proto_mail' => ($member['proto_mail_enabled'] ? $member['proto_mail'] : null)
                    ]);
                    $m->user_id = $member['member_id'];
                    $m->save();
                }

                $address = Address::create([
                    'user_id' => $member['member_id'],
                    'is_primary' => "1",
                    'street' => $member['address_street'],
                    'number' => $member['address_number'],
                    'zipcode' => $member['address_zipcode'],
                    'city' => $member['address_city'],
                    'country' => $member['address_country']
                ]);
                $address->save();

                if ($member['utwente_study'] != '' && $member['utwente_study'] != null) {

                    // Create study if necessary.
                    $study = Study::where('name', $member['utwente_study'])->first();
                    if (!$study) {
                        $study = Study::create([
                            'name' => $member['utwente_study'],
                            'faculty' => "'University of Twente'"
                        ]);
                        $study->save();
                    }

                    $studyEntry = StudyEntry::create([
                        'study_id' => $study->id,
                        'user_id' => $user->id,
                        'start' => strtotime($member['utwente_study_since'] . '-09-01')
                    ]);
                    $studyEntry->save();

                }

                if ($member['bank_iban'] != '') {

                    $bank = Bank::create([
                        'user_id' => $member['member_id'],
                        'iban' => str_replace(" ", "", strtoupper($member['bank_iban'])),
                        'bic' => str_replace(" ", "", strtoupper($member['bank_bic'])),
                        'machtigingid' => $member['bank_machtigingid'],
                        'is_first' => ($member['bank_withdrawal_type'] == 'FRST')
                    ]);
                    $bank->save();

                }


            }

            $this->info('Written ' . User::count() . ' users + userdata to database.');

            // Migrate committees.

            Committee::truncate();
            CommitteeMembership::truncate();

            if (!$this->legacydb->select_db("admin_wp")) {
                $this->error("SWITCHTOWP: " . $this->legacydb->error);
            }

            $committeesquery = $this->legacydb->query("SELECT id, post_date_gmt, post_content, post_title, post_name, post_modified_gmt, post_status FROM wp_posts WHERE (post_type = 'committee' OR post_type = 'society') ORDER BY id ASC");

            while ($committee = $committeesquery->fetch_assoc()) {
                $c = Committee::create([
                    'id' => $committee['id'],
                    'name' => $committee['post_title'],
                    'slug' => $committee['post_name'],
                    'description' => $committee['post_content'],
                    'public' => ($committee['post_status'] == 'publish' ? true : false),
                    'created_at' => $committee['post_date_gmt'],
                    'updated_at' => $committee['post_modified_gmt']
                ]);
                $c->save();
            }

            $this->info('Written ' . Committee::count() . ' committees to database.');

            // Migrating committee participation.

            if (!$this->legacydb->select_db("admin_members")) {
                $this->error("SWITCHTOMEMBERS: " . $this->legacydb->error);
            }

            $committeesparticipation = $this->legacydb->query("SELECT * FROM committees");

            while ($participation = $committeesparticipation->fetch_assoc()) {
                $p = CommitteeMembership::create([
                    'user_id' => $participation['user_id'],
                    'committee_id' => $participation['wordpress_id'],
                    'role' => ($participation['role'] == '' ? null : $participation['role']),
                    'edition' => ($participation['edition'] == '' ? null : $participation['edition']),
                    'start' => strtotime($participation['enroll_start']),
                    'end' => ($participation['enroll_end'] == '2999-12-31' ? null : strtotime($participation['enroll_end']))
                ]);
                $p->save();
            }

            $societiesparticipation = $this->legacydb->query("SELECT * FROM societies");

            while ($participation = $societiesparticipation->fetch_assoc()) {
                $p = CommitteeMembership::create([
                    'user_id' => $participation['user_id'],
                    'committee_id' => $participation['wordpress_id'],
                    'role' => ($participation['role'] == '' ? null : $participation['role']),
                    'edition' => ($participation['edition'] == '' ? null : $participation['edition']),
                    'start' => strtotime($participation['enroll_start']),
                    'end' => ($participation['enroll_end'] == '2999-12-31' ? null : strtotime($participation['enroll_end']))
                ]);
                $p->save();
            }

            $this->info('Written all ' . CommitteeMembership::count() . ' committee participations to database.');

            // Migrate events.

            Event::truncate();

            $url[0] = "https://www.googleapis.com/calendar/v3/calendars/qnuekutikmgts7fanfbccrbqe0@group.calendar.google.com/events?singleEvents=true&orderBy=startTime&key=AIzaSyAaCgF3obw_g1v0kg_uthgw8XFeq_4haao&timeMin=2011-01-01T00%3A00%3A00%2B01%3A00&timeMax=2015-01-01T00%3A00%3A00%2B02%3A00";
            $url[1] = "https://www.googleapis.com/calendar/v3/calendars/qnuekutikmgts7fanfbccrbqe0@group.calendar.google.com/events?singleEvents=true&orderBy=startTime&key=AIzaSyAaCgF3obw_g1v0kg_uthgw8XFeq_4haao&timeMin=2015-01-01T00%3A00%3A00%2B01%3A00&timeMax=2016-01-01T00%3A00%3A00%2B02%3A00";
            $url[2] = "https://www.googleapis.com/calendar/v3/calendars/qnuekutikmgts7fanfbccrbqe0@group.calendar.google.com/events?singleEvents=true&orderBy=startTime&key=AIzaSyAaCgF3obw_g1v0kg_uthgw8XFeq_4haao&timeMin=2016-01-01T00%3A00%3A00%2B01%3A00&timeMax=2017-01-01T00%3A00%3A00%2B02%3A00";

            $eventsdata = array();
            for ($i = 0; $i < 3; $i++) {
                $d = json_decode(file_get_contents($url[$i]));
                foreach ($d->items as $e) {
                    $eventsdata[] = $e;
                }
            }
            $this->info("Retrieved " . count($eventsdata) . " events from Google Calendar.");

            $activityslug2eventid = [];

            foreach ($eventsdata as $event) {

                $e = Event::create([
                    'title' => $event->summary,
                    'description' => property_exists($event, "description") ? $event->description : "No description.",
                    'start' => strtotime((property_exists($event->start, "dateTime") ? $event->start->dateTime : $event->start->date)),
                    'end' => strtotime((property_exists($event->end, "dateTime") ? $event->end->dateTime : $event->end->date)),
                    'location' => property_exists($event, "location") ? $event->location : "Location unknown or no location.",
                    'created_at' => date("Y-m-d H:i:s", strtotime($event->created)),
                    'updated_at' => date("Y-m-d H:i:s", strtotime($event->updated))
                ]);
                $e->save();

                if (property_exists($event, "description") && (preg_match('/.*saproto\.nl\/activity\/([a-zA-Z0-9_-]+)\/{0,1}/', $event->description, $m) || preg_match('/.*saproto\.nl\/\?p=([0-9_-]+)\/{0,1}/', $event->description, $m))) {
                    $activityslug2eventid[$m[1]] = $e->id;
                }

            }

            $this->info('Written ' . Event::count() . ' events to database.');

            // Migrate activities, helping committees.

            Activity::truncate();
            HelpingCommittee::truncate();

            if (!$this->legacydb->select_db("admin_wp")) {
                $this->error("SWITCHTOWP: " . $this->legacydb->error);
            }

            $activitiesquery = $this->legacydb->query("SELECT id, post_date_gmt, post_content, post_title, post_name, post_modified_gmt, post_status FROM wp_posts WHERE post_type = 'activity' AND (post_status = 'publish' OR post_status = 'private') ORDER BY id ASC");

            while ($activity = $activitiesquery->fetch_assoc()) {

                $a = Activity::create([
                    'id' => $activity['id'],
                    'event_id' => (array_key_exists($activity['id'], $activityslug2eventid) ? $activityslug2eventid[$activity['id']] : (array_key_exists($activity['post_name'], $activityslug2eventid) ? $activityslug2eventid[$activity['post_name']] : null)),
                    'price' => 'NULL',
                    'participants' => 'NULL',
                    'registration_start' => 'NULL',
                    'registration_end' => 'NULL',
                    'closed' => 'FALSE',
                    'created_at' => $activity['post_date_gmt'],
                    'updated_at' => $activity['post_modified_gmt']
                ]);
                $a->save();

                if (!$a->event_id) {
                    $this->error('No event found for activity ' . $activity['post_title'] . '. Orphaned.');
                }

                if ($a->event) {
                    $a->event->description = nl2br(preg_replace("/[\r\n]+/", "\n", $activity['post_content']));
                }

                $activitiesmetaquery = $this->legacydb->query("SELECT * FROM wp_postmeta WHERE post_id = " . $activity['id']);
                $activityregstart = array('date' => null, 'time' => null);
                $activityregend = array('date' => null, 'time' => null);

                while ($activitymeta = $activitiesmetaquery->fetch_assoc()) {
                    switch ($activitymeta['meta_key']) {

                        case 'registration_costs':
                            $a->price = ($activitymeta['meta_value'] <= 0 || $activitymeta['meta_value'] == null ? null : $activitymeta['meta_value']);
                            break;
                        case 'registration_limit':
                            $a->participants = ($activitymeta['meta_value'] <= 0 ? null : $activitymeta['meta_value']);
                            break;
                        case 'registration_visibility':
                            if ($a->event) {
                                $a->event->secret = ($activitymeta['meta_value'] != 'visible' ? true : false);
                            }
                            break;
                        case 'closed':
                            $a->closed = true;
                            break;

                        case 'registration_date_start':
                            $activityregstart['date'] = $activitymeta['meta_value'];
                            break;
                        case 'registration_date_end':
                            $activityregend['date'] = $activitymeta['meta_value'];
                            break;
                        case 'registration_time_start':
                            $activityregstart['time'] = $activitymeta['meta_value'];
                            break;
                        case 'registration_time_end':
                            $activityregend['time'] = $activitymeta['meta_value'];
                            break;

                        case 'activists_needed':

                            $needed = json_decode($activitymeta['meta_value']);
                            foreach ($needed as $commid => $amount) {

                                if ($amount > 0) {

                                    $h = HelpingCommittee::create([
                                        'activity_id' => $activity['id'],
                                        'committee_id' => $commid,
                                        'amount' => $amount
                                    ]);
                                    $h->save();

                                }

                            }

                            break;

                    }
                }

                $a->registration_start = strtotime($activityregstart['date'] . " " . $activityregstart['time']) + 0;
                $a->registration_end = strtotime($activityregend['date'] . " " . $activityregend['time']) + 0;
                $a->deregistration_end = $a->registration_end;

                $a->save();

            }

            $this->info('Written ' . Activity::count() . ' activities to database.');

            // Importing activity participation

            ActivityParticipation::truncate();

            if (!$this->legacydb->select_db("admin_members")) {
                $this->error("SWITCHTOMEMBER: " . $this->legacydb->error);
            }

            $usersactivitiesquery = $this->legacydb->query("SELECT * FROM activities");

            while ($useractivity = $usersactivitiesquery->fetch_assoc()) {

                $user = User::where('proto_username', $useractivity['proto_username'])->first();

                if (!$user) {
                    $this->error('No user found for ' . $useractivity['proto_username'] . '.');
                    $user = User::find(0);
                }

                $cp = null;
                if ($useractivity['participant_type'] != -1) {
                    $cp = HelpingCommittee::where('committee_id', $useractivity['participant_type'])->where('activity_id', $useractivity['post_id'])->first();
                }

                $p = ActivityParticipation::create([
                    'user_id' => $user->id,
                    'activity_id' => $useractivity['post_id'],
                    'committees_activities_id' => ($cp != null ? $cp->id : null),
                    'created_at' => $useractivity['date']
                ]);
                $p->save();

            }

            $this->info('Written ' . ActivityParticipation::count() . ' event activity participation to database.');

            // Import quotes

            Quote::truncate();

            if (!$this->legacydb->select_db("admin_wp")) {
                $this->error("SWITCHTOCOMMENT: " . $this->legacydb->error);
            }

            $quotes = $this->legacydb->query("SELECT * FROM wp_comments WHERE comment_post_ID = 342");

            while ($quote = $quotes->fetch_assoc()) {

                $q = Quote::create([
                    'user_id' => 0,
                    'quote' => $quote['comment_content'],
                    'created_at' => $quote['comment_date']
                ]);

                // Jakkes. Waarom sloegen we dat niet fatsoenlijk op?
                $u = User::where('email', $quote['comment_author_email'])->first();
                if ($u === null) {
                    $u = User::where('utwente_username', $quote['comment_author'])->first();
                    if ($u === null) {
                        $u = User::where('proto_username', $quote['comment_author'])->first();
                    }
                }

                if ($u !== null) {
                    $q->user()->associate($u);
                } else {
                    $this->error('Could not link a user to quote ' . $q->id . '.');
                }

                $q->save();

            }

            $this->info('Written ' . Quote::count() . ' quotes to database.');

            // We close the database connection.
            $this->legacydb->close();

            DB::statement("SET foreign_key_checks=1");

            $this->info("Finished!");

        } else {
            $this->error("Aborted. No data has been touched.");
        }

    }
}
