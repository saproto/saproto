<?php

namespace Proto\Console\Commands;

use Illuminate\Console\Command;

class MigrateFromOldSite extends Command
{

    private $laraveldb, $legacydb;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:migrate {--no-confirmation : Skips the confirmation questions.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command synchronizes the old datebase to the new one.';

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
            error_reporting(E_ALL);
            ini_set("display_errors", 1);

            // We open the database connection.
            $this->legacydb = mysqli_connect(getenv('OLD_DB_HOST'), getenv('OLD_DB_USERNAME'), getenv('OLD_DB_PASSWORD'));
            $this->laraveldb = mysqli_connect(getenv('DB_HOST'), getenv('DB_USERNAME'), getenv('DB_PASSWORD'), getenv('DB_DATABASE'));

            // First, we get all members.
            $this->legacydb->select_db("admin_members");
            $membersquery = $this->legacydb->query("SELECT * FROM members");

            // For each object, we construct the data hierarchy for Laravel.
            $users = array();
            $studies = array();

            $study2id = array();
            $studnr2id = array();
            $commsevents2id = array();
            $commseventscounter = 1;

            while ($member = $membersquery->fetch_assoc()) {

                $studnr2id[$member['proto_username']] = $member['member_id'];

                if ($member['utwente_study'] != '') {
                    if (!in_array($member['utwente_study'], $study2id)) {
                        array_push($study2id, $member['utwente_study']);
                        $studyid = array_search($member['utwente_study'], $study2id) + 1;
                        $studies[$studyid] = array(
                            'studydata' => array(
                                'id' => $studyid,
                                'name' => "'" . $member['utwente_study'] . "'",
                                'faculty' => "'University of Twente'"
                            )
                        );
                    }
                    $studyid = array_search($member['utwente_study'], $study2id) + 1;
                }

                $users[$member['member_id']] = array(
                    'userdata' => array(
                        'id' => $this->laraveldb->real_escape_string($member['member_id']),
                        'email' => "'" . $this->laraveldb->real_escape_string($member['contact_email']) . "'",
                        'password' => "'correct horse battery staple'",
                        'utwente_username' => ($member['utwente_relation'] == 1 ? "'" . $this->laraveldb->real_escape_string($member['utwente_username']) . "'" : 'NULL'),
                        'name_first' => "'" . $this->laraveldb->real_escape_string($member['name_first']) . "'",
                        'name_last' => "'" . $this->laraveldb->real_escape_string($member['name_last']) . "'",
                        'name_initials' => "'" . $this->laraveldb->real_escape_string($member['name_initials']) . "'",
                        'birthdate' => "'" . $this->laraveldb->real_escape_string($member['person_birthdate']) . "'",
                        'gender' => $this->laraveldb->real_escape_string($member['person_gender']),
                        'nationality' => "'" . $this->laraveldb->real_escape_string($member['person_nationality']) . "'",
                        'phone' => "'" . $this->laraveldb->real_escape_string($member['contact_phone']) . "'",
                        'website' => "'" . $this->laraveldb->real_escape_string($member['profile_website']) . "'",
                        'biography' => "'" . $this->laraveldb->real_escape_string($member['profile_biography']) . "'",
                        'phone_visible' => $this->laraveldb->real_escape_string($member['privacy_phone_visible']),
                        'address_visible' => $this->laraveldb->real_escape_string($member['privacy_address_visible']),
                        'receive_newsletter' => $this->laraveldb->real_escape_string($member['privacy_receive_newsletter']),
                        'receive_sms' => $this->laraveldb->real_escape_string($member['privacy_receive_sms']),
                        'created_at' => "'" . $member['member_since'] . "'"
                    ),
                    'memberdata' => (strtotime($member['member_till']) > date('U') ? array(
                        'user_id' => $this->laraveldb->real_escape_string($member['member_id']),
                        '`type`' => "'" . $this->laraveldb->real_escape_string($member['member_type']) . "'",
                        'fee_cycle' => "'" . $this->laraveldb->real_escape_string($member['fee_cycle']) . "'",
                        'primary_member' => ($member['association_primary'] == null ? 'FALSE' : 'TRUE'),
                        'till' => ($member['member_till'] == '2099-01-01' ? 'NULL' : "'" . $this->laraveldb->real_escape_string($member['member_till']) . "'"),
                        'proto_mail' => ($member['proto_mail_enabled'] == 1 ? "'" . $this->laraveldb->real_escape_string($member['proto_mail']) . "'" : 'NULL'),
                        'created_at' => "'" . $member['member_since'] . "'"
                    ) : false),
                    'bankdata' => array(
                        'user_id' => $this->laraveldb->real_escape_string($member['member_id']),
                        'iban' => "'" . str_replace(" ", "", strtoupper($this->laraveldb->real_escape_string($member['bank_iban']))) . "'",
                        'bic' => "'" . str_replace(" ", "", strtoupper($this->laraveldb->real_escape_string($member['bank_bic']))) . "'",
                        'machtigingid' => "'" . $this->laraveldb->real_escape_string($member['bank_machtigingid']) . "'",
                        'withdrawal_type' => "'" . $this->laraveldb->real_escape_string($member['bank_withdrawal_type']) . "'"
                    ),
                    'addresses' => array(
                        'user_id' => $this->laraveldb->real_escape_string($member['member_id']),
                        'is_primary' => "1",
                        'street' => "'" . $this->laraveldb->real_escape_string($member['address_street']) . "'",
                        'number' => "'" . $this->laraveldb->real_escape_string($member['address_number']) . "'",
                        'zipcode' => "'" . $this->laraveldb->real_escape_string($member['address_zipcode']) . "'",
                        'city' => "'" . $this->laraveldb->real_escape_string($member['address_city']) . "'",
                        'country' => "'" . $this->laraveldb->real_escape_string($member['address_country']) . "'"
                    ),
                    'studylinks' => ($member['utwente_study'] != '' ? array(
                        'study_id' => $studyid,
                        'user_id' => $this->laraveldb->real_escape_string($member['member_id']),
                        'created_at' => "'" . $member['utwente_study_since'] . '-09-01' . "'"
                    ) : false)
                );
            }


            // Now we continue with the committee participations.
            $participation = array();
            $committeesparticipation = $this->legacydb->query("SELECT * FROM committees");

            while ($committeeparticipation = $committeesparticipation->fetch_assoc()) {
                $participation[]['data'] = array(
                    'user_id' => $committeeparticipation['user_id'],
                    'committee_id' => $committeeparticipation['wordpress_id'],
                    'role' => ($committeeparticipation['role'] == '' ? 'NULL' : "'" . $this->laraveldb->real_escape_string($committeeparticipation['role']) . "'"),
                    'edition' => ($committeeparticipation['edition'] == '' ? 'NULL' : "'" . $this->laraveldb->real_escape_string($committeeparticipation['edition']) . "'"),
                    'start' => "'" . $committeeparticipation['enroll_start'] . "'",
                    'end' => ($committeeparticipation['enroll_end'] == '2999-12-31' ? 'NULL' : "'" . $committeeparticipation['enroll_end'] . "'")
                );
            }

            $societiesparticipation = $this->legacydb->query("SELECT * FROM societies");
            while ($societyparticipation = $societiesparticipation->fetch_assoc()) {
                $participation[]['data'] = array(
                    'user_id' => $societyparticipation['user_id'],
                    'committee_id' => $societyparticipation['wordpress_id'],
                    'role' => ($societyparticipation['role'] == '' ? 'NULL' : "'" . $this->laraveldb->real_escape_string($societyparticipation['role']) . "'"),
                    'edition' => ($societyparticipation['edition'] == '' ? 'NULL' : "'" . $this->laraveldb->real_escape_string($societyparticipation['edition']) . "'"),
                    'start' => "'" . $societyparticipation['enroll_start'] . "'",
                    'end' => ($societyparticipation['enroll_end'] == '2999-12-31' ? 'NULL' : "'" . $societyparticipation['enroll_end'] . "'")
                );
            }

            // Now we switch to the wordpress table.
            if (!$this->legacydb->select_db("admin_wp")) {
                $this->error("SWITCHTOWP: " . $this->legacydb->error);
            }

            // Now we do commitees.
            $committees = array();
            $committeesquery = $this->legacydb->query("SELECT id, post_date_gmt, post_content, post_title, post_name, post_modified_gmt, post_status FROM wp_posts WHERE (post_type = 'committee' OR post_type = 'society') ORDER BY id ASC");

            while ($committee = $committeesquery->fetch_assoc()) {
                $committees[$committee['id']]['data'] = array(
                    'id' => $committee['id'],
                    'name' => "'" . $committee['post_title'] . "'",
                    'slug' => "'" . $committee['post_name'] . "'",
                    'description' => "'" . $this->laraveldb->real_escape_string($committee['post_content']) . "'",
                    'public' => ($committee['post_status'] == 'publish' ? 'TRUE' : 'FALSE'),
                    'created_at' => "'" . $committee['post_date_gmt'] . "'",
                    'updated_at' => "'" . $committee['post_modified_gmt'] . "'"
                );
            }

            // Now we do activities.
            $activities = array();
            $commsevents = array();
            $activitiesquery = $this->legacydb->query("SELECT id, post_date_gmt, post_content, post_title, post_name, post_modified_gmt, post_status FROM wp_posts WHERE post_type = 'activity' AND (post_status = 'publish' OR post_status = 'private') ORDER BY id ASC");

            while ($activity = $activitiesquery->fetch_assoc()) {
                $activities[$activity['id']]['data'] = array(
                    'id' => $activity['id'],
                    'event_id' => 1,
                    'price' => 'NULL',
                    'participants' => 'NULL',
                    'registration_start' => 'NULL',
                    'registration_end' => 'NULL',
                    'secret' => 'FALSE',
                    'active' => ($activity['post_status'] == 'publish' ? 'TRUE' : 'FALSE'),
                    'closed' => 'FALSE',
                    'created_at' => "'" . $activity['post_date_gmt'] . "'",
                    'updated_at' => "'" . $activity['post_modified_gmt'] . "'"
                );

                $activitiesmetaquery = $this->legacydb->query("SELECT * FROM wp_postmeta WHERE post_id = " . $activity['id']);
                $activityregstart = array('date' => null, 'time' => null);
                $activityregend = array('date' => null, 'time' => null);
                while ($activitymeta = $activitiesmetaquery->fetch_assoc()) {
                    switch ($activitymeta['meta_key']) {
                        case 'registration_costs':
                            $activities[$activity['id']]['data']['price'] = ($activitymeta['meta_value'] <= 0 || $activitymeta['meta_value'] == null ? 'NULL' : $activitymeta['meta_value']);
                            break;
                        case 'registration_limit':
                            $activities[$activity['id']]['data']['participants'] = ($activitymeta['meta_value'] <= 0 ? 'NULL' : $activitymeta['meta_value']);
                            break;
                        case 'registration_visibility':
                            $activities[$activity['id']]['data']['secret'] = ($activitymeta['meta_value'] != 'visible' ? 'TRUE' : 'FALSE');
                            break;
                        case 'closed':
                            $activities[$activity['id']]['data']['closed'] = 'TRUE';
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
                                    $commsevents[$commseventscounter]['data'] = array(
                                        'id' => $commseventscounter,
                                        'event_id' => $activity['id'],
                                        'committee_id' => $commid,
                                        'amount' => $amount
                                    );
                                    $commsevents2id[$commid][$activity['id']] = $commseventscounter;
                                    $commseventscounter++;
                                }
                            }
                            break;
                    }
                }

                $activities[$activity['id']]['data']['registration_start'] = "'" . date("Y-m-d H:i:s", strtotime($activityregstart['date'] . " " . $activityregstart['time'])) . "'";
                $activities[$activity['id']]['data']['registration_end'] = "'" . date("Y-m-d H:i:s", strtotime($activityregend['date'] . " " . $activityregend['time'])) . "'";
            }

            if (!$this->legacydb->select_db("admin_members")) {
                $this->error("SWITCHTOMEMBER: " . $this->legacydb->error);
            }

            $usersactivities = array();
            $usersactivitiesquery = $this->legacydb->query("SELECT * FROM activities");
            $usersactivitiescounter = 1;

            while ($useractivity = $usersactivitiesquery->fetch_assoc()) {
                if (!array_key_exists($useractivity['proto_username'], $studnr2id)) {
                    continue;
                }
                $usersactivities[$usersactivitiescounter]['data'] = array(
                    'user_id' => $studnr2id[$useractivity['proto_username']],
                    'activity_id' => $useractivity['post_id'],
                    'committees_events_id' => ($useractivity['participant_type'] != -1 ? $commsevents2id[$useractivity['participant_type']][$useractivity['post_id']] : 'NULL'),
                    'created_at' => "'" . $useractivity['date'] . "'"
                );
                $usersactivitiescounter++;
            }

            // Now, we empty the Laravel database.
            if (!$this->laraveldb->query("SET FOREIGN_KEY_CHECKS = 0")) {
                $this->error("TRUNCATEPRE: " . $this->laraveldb->error);
            }
            if (!$this->laraveldb->query("TRUNCATE TABLE members")) {
                $this->error("TRUNCATE members: " . $this->laraveldb->error);
            }
            if (!$this->laraveldb->query("TRUNCATE TABLE addresses")) {
                $this->error("TRUNCATE addresses: " . $this->laraveldb->error);
            }
            if (!$this->laraveldb->query("TRUNCATE TABLE bankaccounts")) {
                $this->error("TRUNCATE bankaccounts: " . $this->laraveldb->error);
            }
            if (!$this->laraveldb->query("TRUNCATE TABLE users")) {
                $this->error("TRUNCATE users: " . $this->laraveldb->error);
            }
            if (!$this->laraveldb->query("TRUNCATE TABLE studies")) {
                $this->error("TRUNCATE studies: " . $this->laraveldb->error);
            }
            if (!$this->laraveldb->query("TRUNCATE TABLE studies_users")) {
                $this->error("TRUNCATE studiesusers: " . $this->laraveldb->error);
            }
            if (!$this->laraveldb->query("TRUNCATE TABLE activities")) {
                $this->error("TRUNCATE activities: " . $this->laraveldb->error);
            }
            if (!$this->laraveldb->query("TRUNCATE TABLE activities_users")) {
                $this->error("TRUNCATE activities_users: " . $this->laraveldb->error);
            }
            if (!$this->laraveldb->query("TRUNCATE TABLE committees")) {
                $this->error("TRUNCATE committees: " . $this->laraveldb->error);
            }
            if (!$this->laraveldb->query("TRUNCATE TABLE committees_events")) {
                $this->error("TRUNCATE committees_events: " . $this->laraveldb->error);
            }
            if (!$this->laraveldb->query("TRUNCATE TABLE committees_users")) {
                $this->error("TRUNCATE committees_users: " . $this->laraveldb->error);
            }
            if (!$this->laraveldb->query("TRUNCATE TABLE studies_users")) {
                $this->error("TRUNCATE studiesusers: " . $this->laraveldb->error);
            }
            if (!$this->laraveldb->query("SET FOREIGN_KEY_CHECKS = 1")) {
                $this->error("TRUNCATEPOST: " . $this->laraveldb->error);
            }

            // And now we add data!
            $this->write_to_db($users, 'userdata', 'users');
            $this->write_to_db($users, 'memberdata', 'members');
            $this->write_to_db($users, 'bankdata', 'bankaccounts');
            $this->write_to_db($users, 'addresses', 'addresses');
            $this->write_to_db($users, 'studylinks', 'studies_users');
            $this->write_to_db($studies, 'studydata', 'studies');

            $this->write_to_db($committees, 'data', 'committees');
            $this->write_to_db($participation, 'data', 'committees_users');
            $this->write_to_db($commsevents, 'data', 'committees_events');

            $this->write_to_db($activities, 'data', 'activities');
            $this->write_to_db($usersactivities, 'data', 'activities_users');

            // We close the database connection.
            $this->legacydb->close();
            $this->laraveldb->close();

            $this->info("Finished except for the errors thrown.");
        } else {
            $this->error("Aborted. No data has been touched.");
        }
    }

    /**
     * Shared code to write a dataset to the database.
     *
     * @param $dataset Which array the data is to be gathered from.
     * @param $data_name Which dataset from the array should be written to the database.
     * @param $table_name Which table name in the new database should the data be written to.
     */
    function write_to_db($dataset, $data_name, $table_name)
    {
        foreach ($dataset as $ref_id => $data) {

            if ($dataset[$ref_id][$data_name] != null && $dataset[$ref_id][$data_name] != false) {

                $columns = "";
                $values = "";

                foreach ($dataset[$ref_id][$data_name] as $field => $value) {
                    $columns .= $field . ",";
                    $values .= $value . ",";
                }

                if (!array_key_exists('created_at', $dataset[$ref_id][$data_name])) {
                    $columns .= "created_at,";
                    $values .= "NOW(),";
                }

                if (!array_key_exists('updated_at', $dataset[$ref_id][$data_name])) {
                    $columns .= "updated_at,";
                    $values .= "NOW(),";
                }

                $columns = substr($columns, 0, -1);
                $values = substr($values, 0, -1);

                $query = "INSERT INTO $table_name ($columns) VALUES ($values);";
                if (!$this->laraveldb->query($query)) {
                    $this->error("$table_name($ref_id): $query " . PHP_EOL . $this->laraveldb->error . PHP_EOL);
                }

            }

        }
    }
}
