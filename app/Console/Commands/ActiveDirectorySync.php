<?php

namespace Proto\Console\Commands;

use Adldap\Adldap;
use Adldap\Connections\Provider;

use Illuminate\Console\Command;
use Proto\Models\Member;
use Proto\Models\Committee;

/**
 * TODO
 * Autorelate permissions to roles.
 */
class ActiveDirectorySync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'proto:adsync';

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

        $ad = new Adldap();
        $provider = new Provider(config('adldap.proto'));
        $ad->addProvider('proto', $provider);
        $ad->connect('proto');

        $this->info("Connected to LDAP server.");

        $this->info("Synchronizing users to LDAP.");
        $this->syncUsers($provider);

        $this->info("Synchronizing committees to LDAP.");
        $this->syncCommittees($provider);

        $this->info("Synchronizing committees members to LDAP.");
        $this->syncCommitteeMembers($provider);

        $this->info("Done!");

    }

    private function syncUsers($provider)
    {

        $activeIds = [];

        $this->info("Make sure all users exist in LDAP.");

        foreach (Member::all() as $member) {

            $activeIds[] = $member->user->id;
            $user = $provider->search()->where('objectClass', 'user')->where('description', $member->user->id)->first();

            if ($user == null) {
                $this->info('Creating LDAP user for ' . $member->user->name . '.');
                $user = $provider->make()->user();
                $user->cn = trim($member->user->name);
                $user->description = $member->user->id;
                $user->save();
            }

            $user->move('cn=' . trim($member->user->name), 'OU=Members,OU=Proto,DC=net,DC=saproto,DC=nl');

            $user->displayName = trim($member->user->name);
            $user->givenName = $member->user->calling_name;

            $user->mail = $member->proto_username . '@' . config('proto.emaildomain');
            $user->wWWHomePage = $member->user->website;

            $user->l = $member->user->address->city;
            $user->postalCode = $member->user->address->zipcode;
            $user->streetAddress = $member->user->address->street . " " . $member->user->address->number;

            $user->telephoneNumber = $member->user->phone;

            $user->setAttribute('sAMAccountName', $member->proto_username);
            $user->setUserPrincipalName($member->proto_username . config('adldap.proto')['account_suffix']);

            $user->save();

        }

        $this->info("Removing obsolete users from LDAP.");

        $users = $provider->search()->users()->get();

        foreach ($users as $user) {
            if (!$user->description[0] || !in_array($user->description[0], $activeIds)) {
                $this->info("Deleting LDAP user " . $user->description[0] . ".");
                $user->delete();
            }
        }

    }

    private function syncCommittees($provider)
    {

        $activeIds = [];

        $this->info("Make sure all committees exist in LDAP.");

        foreach (Committee::all() as $committee) {

            $activeIds[] = $committee->id;
            $group = $provider->search()->where('objectClass', 'group')->where('description', $committee->id)->first();

            if ($group == null) {
                $this->info('Creating LDAP group for ' . $committee->name . '.');
                $group = $provider->make()->group();
                $group->cn = trim($committee->name);
                $group->description = $committee->id;
                $group->save();
            }

            $group->move('cn=' . trim($committee->name), 'OU=Committees,OU=Proto,DC=net,DC=saproto,DC=nl');
            $group->displayName = trim($committee->name);
            $group->description = $committee->id;
            $group->mail = $committee->slug . '@' . config('proto.emaildomain');
            $group->url = route("committee::show", ['id' => $committee->id]);

            $group->setAttribute('sAMAccountName', $committee->slug);

            $group->save();

        }

        $this->info("Removing obsolete committees from LDAP.");

        $committees = $provider->search()->groups()->get();

        foreach ($committees as $group) {
            if (!$group->description[0] || !in_array($group->description[0], $activeIds)) {
                $this->info("Deleting LDAP group " . $group->description[0] . ".");
                $group->delete();
            }
        }

    }

    private function syncCommitteeMembers($provider)
    {

        $groups = $provider->search()->groups()->get();

        $user2ldap = [];

        foreach ($groups as $group) {

            $this->info('Setting members for ' . $group->name[0] . '.');

            $committee = Committee::findOrFail($group->description[0]);

            $newmembers = [];

            foreach ($committee->users as $user) {

                if (!array_key_exists($user->id, $user2ldap)) {

                    $ldapuser = $provider->search()->where('objectClass', 'user')->where('description', $user->id)->first();
                    if ($ldapuser !== null) {
                        $user2ldap[$user->id] = $ldapuser;
                    } else {
                        $this->error("No LDAP user found for " . $user->name . ".");
                        continue;
                    }

                }

                if (!in_array($user2ldap[$user->id]->dn, $newmembers)) {
                    $newmembers[] = $user2ldap[$user->id]->dn;
                }

            }

            $group->setMembers($newmembers);
            $group->save();

        }

    }

}
