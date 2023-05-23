<?php

namespace Proto\Console\Commands;

use Illuminate\Console\Command;
use Proto\Models\Alias;
use Proto\Models\Committee;
use Proto\Models\EmailDbAlias;
use Proto\Models\EmailDbDomain;
use Proto\Models\User;

class MailAliasSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'proto:aliassync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Manages e-mail accounts and lists via Postfix.';

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
        $domain = EmailDbDomain::where('name', config('proto.emaildomain'))->first();
        if (! $domain) {
            $this->error('The e-mail domain does not exist, please create it!');

            return;
        }

        $target = $this->constructForwarderList();

        $this->applyForwarderList($target, $domain);

        $this->info('Done!');
    }

    private function makeFullAlias($source)
    {
        return strtolower(sprintf('%s@%s', $source, config('proto.emaildomain')));
    }

    private function applyForwarderList($target, $domain)
    {

        // Clean-up old
        $aliases = EmailDbAlias::where('domain_id', $domain->id)->get();
        foreach ($aliases as $alias) {
            if (! in_array($alias->source, array_keys($target))) {
                $this->info(sprintf('Deleting forward: %s -> %s', $alias->source, $alias->destination));
                $alias->delete();

                continue;
            }
            if (! in_array($alias->destination, $target[$alias->source])) {
                $this->info(sprintf('Deleting forward: %s -> %s', $alias->source, $alias->destination));
                $alias->delete();

                continue;
            }
        }

        // Create non-existing
        foreach ($target as $source => $destinations) {
            foreach ($destinations as $destination) {
                $alias = EmailDbAlias::where('domain_id', $domain->id)->where('source', $source)->where('destination', $destination)->first();
                if (! $alias) {
                    $alias = EmailDbAlias::create([
                        'domain_id' => $domain->id,
                        'source' => $source,
                        'destination' => $destination,
                    ]);
                    $this->info(sprintf('Creating forward: %s -> %s', $source, $destination));
                }
            }
        }
    }

    private function constructForwarderList()
    {
        $data = [];

        // Constructing user forwarders.
        /** @var User[] $users */
        $users = User::all();
        foreach ($users as $user) {
            if ($user->is_member && $user->isActiveMember()) {
                $data[$this->makeFullAlias($user->member->proto_username)] = [
                    $user->email,
                ];
            }
        }

        // Constructing committee forwarders.
        /** @var Committee[] $committees */
        $committees = Committee::all();
        foreach ($committees as $committee) {
            $destinations = [];

            foreach ($committee->users as $user) {
                $destinations[] = $user->email;
            }

            if (count($destinations) > 0) {
                $data[$this->makeFullAlias($committee->slug)] = $destinations;
            }
        }

        // Constructing manual aliases.
        $aliases = Alias::all();
        foreach ($aliases as $alias) {
            if ($alias->destination) {
                $data[$this->makeFullAlias($alias->alias)][] = $alias->destination;
            } elseif ($alias->user) {
                $data[$this->makeFullAlias($alias->alias)][] = $alias->user->email;
            }
        }

        return $data;
    }
}
