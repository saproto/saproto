<?php

namespace Proto\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use DirectAdmin\DirectAdmin;

use Proto\Models\Alias;
use Proto\Models\Committee;
use Proto\Models\CommitteeMembership;
use Proto\Models\Member;


/**
 * TODO
 * Autorelate permissions to roles.
 */
class DirectAdminSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'proto:dasync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Manages e-mail accounts and lists via DirectAdmin.';

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

        $da = new DirectAdmin;
        $da->connect(getenv('DA_HOSTNAME'), getenv('DA_PORT'));
        $da->set_login(getenv('DA_USERNAME'), getenv('DA_PASSWORD'));

        // Mail forwarders
        $da->set_method('get');
        $da->query($this->constructQuery('CMD_API_EMAIL_FORWARDERS', [
            'domain' => getenv('DA_DOMAIN')
        ]));

        $current = $this->decodeForwarders($da->fetch_body());
        $target = $this->constructForwarderList();

        $patch = $this->constructPatchList($current, $target);

        $forwarder_queries = $this->applyPatchList($patch);

        // E-mail accounts
        $da->query($this->constructQuery('CMD_API_POP', [
            'domain' => getenv('DA_DOMAIN'),
            'action' => 'list'
        ]));

        $current = $this->decodeAccounts($da->fetch_body());
        $target = $this->constructAccountList();

        $patch = $this->constructAccountPatchList($current, $target);

        $account_queries = $this->applyAccountPatchList($patch);

        // Execute queries
        $this->executeQueries($da, array_merge($forwarder_queries, $account_queries));

        $this->info('Done!');
    }

    public static function constructQuery($command, $options = [])
    {
        $query = '/' . $command;
        if (count($options) > 0) {
            $query .= '?';
            foreach ($options as $key => $val) {
                $query .= $key . '=' . urlencode($val) . '&';
            }
        }
        return $query;
    }

    private function decodeForwarders($string)
    {
        $data = [];
        if (strlen($string) > 0) {
            $array = explode('&', urldecode($string));
            foreach ($array as $entry) {
                $item = explode('=', $entry);
                $data[$item[0]] = (array)explode(',', $item[1]);
            }
        }
        return $data;
    }

    private function decodeAccounts($string)
    {
        $data = [];
        if (strlen($string) > 0) {
            $array = explode('&', urldecode($string));
            foreach ($array as $entry) {
                $item = explode('=', $entry);
                $data[] = $item[1];
            }
        }
        return $data;

    }

    private function decodeResponse($string)
    {
        $data = [];
        $array = explode('&', urldecode($string));
        for ($i = 0; $i < 2; $i++) {
            $e = explode('=', $array[$i]);
            $data[$e[0]] = $e[1];
        }
        return $data;
    }

    private function constructForwarderList()
    {
        $data = [];

        // Constructing user forwarders.
        $members = Member::get();
        foreach ($members as $member) {
            $data[$member->proto_username] = [
                $member->user->email
            ];
        }

        // Constructing committee forwarders.
        $committees = Committee::all();
        foreach ($committees as $committee) {

            $destinations = [];

            $users = CommitteeMembership::withTrashed()
                ->where('committee_id', $committee->id)
                ->where('created_at', '<', date('Y-m-d H:i:s'))
                ->where(function ($q) {
                    $q->whereNull('deleted_at')
                        ->orWhere('deleted_at', '>', date('Y-m-d H:i:s'));
                })->get();

            foreach ($users as $user) {
                $destinations[] = $user->user->email;
            }

            if (count($destinations) > 0) {
                $data[strtolower($committee->slug)] = $destinations;
                $data['committees'][] = strtolower($committee->slug . '@' . config('proto.emaildomain'));
            }

        }

        // Constructing manual aliases.
        $aliases = Alias::all();
        foreach ($aliases as $alias) {
            if ($alias->destination) {
                $data[$alias->alias][] = $alias->destination;
            } else {
                $data[$alias->alias][] = $alias->user->email;
            }
        }

        return $data;
    }

    private function constructAccountList()
    {
        $data = [];

        $members = Member::get();
        foreach ($members as $member) {
            $data[] = $member->proto_username;
        }

        return $data;
    }

    private function constructPatchList($current, $target)
    {
        $data = [
            'add' => [],
            'mod' => [],
            'del' => []
        ];

        // For each current forwarder, we check if it should exist against the target list.
        foreach ($current as $alias => $destination) {

            // It should exist, now we check if the forwarder needs to be rewritten.
            if (array_key_exists($alias, $target)) {

                // If one target destination is not currently present, rewrite whole forwarder.
                foreach ($target[$alias] as $d) {
                    if (!in_array($d, $destination)) {
                        $data['mod'][$alias] = $target[$alias];
                        break;
                    }
                }

                // If one current destination should not be present, rewrite whole forwarder.
                foreach ($destination as $d) {
                    if (!in_array($d, $target[$alias])) {
                        $data['mod'][$alias] = $target[$alias];
                        break;
                    }
                }

                // Otherwise, we do not modify this alias.

            } else {
                // The forwarder should not exist according to the target list. Remove the forwarder.
                $data['del'][] = $alias;
            }
        }

        // Now we check if we need to create any new forwarder.
        foreach ($target as $alias => $destination) {

            // A forwarder does not yet exist...
            if (!array_key_exists($alias, $current)) {
                $data['add'][$alias] = $destination;
            }

        }

        return $data;
    }

    private function constructAccountPatchList($current, $target)
    {
        $data = [
            'add' => [],
            'del' => []
        ];

        // For each current account, we check if it should exist against the target list.
        foreach ($current as $account) {

            // The account should not exist!
            if (!in_array($account, $target)) {
                $data['del'][] = $account;
            }

        }

        // Now we check if we need to create any new accounts.
        foreach ($target as $account) {

            // The account should be created!
            if (!in_array($account, $current)) {
                $data['add'][] = $account;
            }

        }

        return $data;
    }

    private function applyPatchList($patch)
    {

        $queries = [];

        foreach ($patch['add'] as $alias => $destination) {
            $queries[] = $this->constructQuery('CMD_API_EMAIL_FORWARDERS', [
                'domain' => getenv('DA_DOMAIN'),
                'action' => 'create',
                'user' => $alias,
                'email' => implode(',', $destination)
            ]);
        }

        foreach ($patch['mod'] as $alias => $destination) {
            $queries[] = $this->constructQuery('CMD_API_EMAIL_FORWARDERS', [
                'domain' => getenv('DA_DOMAIN'),
                'action' => 'modify',
                'user' => $alias,
                'email' => implode(',', $destination)
            ]);
        }

        foreach ($patch['del'] as $del) {
            $queries[] = $this->constructQuery('CMD_API_EMAIL_FORWARDERS', [
                'domain' => getenv('DA_DOMAIN'),
                'action' => 'delete',
                'select0' => $del,
            ]);
        }

        return $queries;

    }

    private function applyAccountPatchList($patch)
    {
        $queries = [];

        foreach ($patch['add'] as $account) {
            $password = Str::random(32);
            $queries[] = $this->constructQuery('CMD_API_POP', [
                'domain' => getenv('DA_DOMAIN'),
                'action' => 'create',
                'user' => $account,
                'passwd' => $password,
                'passwd2' => $password,
                'quota' => 1,
                'limit' => 0 # Unlimited
            ]);
        }

        foreach ($patch['del'] as $account) {
            $queries[] = $this->constructQuery('CMD_API_POP', [
                'domain' => getenv('DA_DOMAIN'),
                'action' => 'delete',
                'user' => $account,
            ]);
        }

        return $queries;

    }

    private function executeQueries($da, $queries)
    {
        foreach ($queries as $i => $query) {

            $this->info('Query ' . $i . '/' . count($queries) . ': ' . $query);

            $da->set_method('get');
            $da->query($query);

            $response = $this->decodeResponse($da->fetch_body());
            if ($response['error'] == 1) {
                $this->info('Error: ' . $response['text'] . PHP_EOL);
            }

        }

    }
}