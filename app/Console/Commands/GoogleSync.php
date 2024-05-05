<?php

namespace App\Console\Commands;

use App\Console\ConsoleOutput;
use App\Models\Alias as ProtoAlias;
use App\Models\Committee as ProtoGroup;
use App\Models\User as ProtoUser;
use Google\Service\Directory\Alias as GoogleAlias;
use Google\Service\Directory\UserExternalId;
use Google\Service\Directory\UserName;
use Google\Service\Directory\User as GoogleUser;
use Google\Service\Directory\Group as GoogleGroup;
use Google\Service\Directory\Member as GoogleGroupMembership;
use Google\Service\Exception;
use Google\Service\Gmail;
use Google\Service\Gmail\ForwardingAddress;
use Illuminate\Console\Command;
use Google\Service\Directory;
use Google_Client;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Throwable;

class GoogleSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'proto:gsync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Manages e-mail accounts and lists via Google Workspace API.';

    /**
     * The Google Directory service.
     *
     * @var Directory
     */
    private Directory $directory;

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
     * @throws Throwable
     */
    public function handle()
    {
        $this->output = new ConsoleOutput();
        if (!app()->environment('production')) {
            $this->output->warning("Don't sync your local users to Google!");
            return true;
        }
        $client = $this->createClient(
            'superadmin@proto.utwente.nl',
            [
                'https://www.googleapis.com/auth/admin.directory.user',
                'https://www.googleapis.com/auth/admin.directory.group',
                'https://www.googleapis.com/auth/admin.directory.group.member',
            ]
        );
        $this->directory = new Directory($client);
        $this->syncProtoGroupsWithGoogleGroups();
        $this->syncProtoUsersWithGoogleUsers();
        return 0;
    }

    private function pp($message, $func=null) {
        try {
            $this->output->task($message, $func);
        } catch (Throwable) {
            /* Ignored */
        }
    }

    /**
     * Create Google Client for subject with given scopes.
     * @param string $subject
     * @param array $scopes
     * @return Google_Client
     */
    public function createClient(string $subject, array $scopes)
    {
        $client = new Google_Client();
        $client->useApplicationDefaultCredentials();
        $client->setSubject($subject);
        $client->setApplicationName('Proto Website');
        $client->setScopes($scopes);
        return $client;
    }

    /**
     * Synchronise the current Proto groups with the Google Workspace groups.
     * @return void
     * @throws Throwable
     */
    public function syncProtoGroupsWithGoogleGroups()
    {
        $this->output->info('Groups:');
        $protoGroups = ProtoGroup::all()->where('public');
        $googleGroups = $this->listGoogleGroups();
        foreach ($protoGroups as $protoGroup) {
            // Try to find the group in Google Workspace by email.
            if (($googleGroup = $googleGroups->firstWhere("email", $protoGroup->email)) != null) {
                $description = str_replace("\r", ' ', $protoGroup->description);
                $description = str_replace("\"", '', $description);
                $description = strip_tags($description);
                // Check whether a group in Google Workspace exists and try to update it.
                if ($googleGroup->description != $description) {
                    $googleGroup->setDescription($description);
                    try {
                        $this->pp(
                            '<fg=blue>⟳</> ' . str_pad("#$protoGroup->id", 6) . str_pad("$protoGroup->name <fg=gray>", 65, '.') . '</> ✎ Description',
                            fn() => $this->directory->groups->patch($googleGroup->id, $googleGroup)
                        );
                    } catch (Throwable $e) {/* Ignored */
                    }
                } else {
                    $this->pp('<fg=green>✓</> ' . str_pad("#$protoGroup->id", 6) . $protoGroup->name);
                }
                // Try to find the group in Google Workspace by name if it was not found by email.
            } else if (($googleGroup = $googleGroups->firstWhere("name", $protoGroup->name)) != null) {
                $googleGroup->setEmail($protoGroup->email);
                $this->pp(
                    '<fg=blue>⟳</> ' . str_pad("#$protoGroup->id", 6) . str_pad("$protoGroup->name <fg=gray>", 65, ".") . "</> ✎ $protoGroup->email",
                    fn() => $this->directory->groups->patch($googleGroup->id, $googleGroup)
                );
            // Create the group if it was not found.
            } else {
                $this->pp(
                    "<fg=yellow>+</> " . str_pad("#$protoGroup->id", 6) . $protoGroup->name,
                    fn() => $this->directory->groups->insert(
                        new GoogleGroup([
                            'name' => $protoGroup->name,
                            'email' => $protoGroup->email,
                            'description' => $protoGroup->description,
                        ])
                    )
                );
            }
        }
    }

    /**
     * Synchronise the current Proto users with the Google Workspace users.
     * @return void
     * @throws Throwable
     */
    public function syncProtoUsersWithGoogleUsers()
    {
        $this->output->info('Users:');
        /* @var Collection<ProtoUser> $protoUsers */
        $protoUsers = ProtoUser::query()
            ->whereHas('member')
            ->get()
            ->filter(function ($user) {
                return $user->isActiveMember();
            });
        $googleUsers = $this->listGoogleUsers();

        // Remove Google Workspace users that are no longer in active member list.
        /* @var Collection<ProtoUser> $usersToRemove */
        $usersToRemove = $googleUsers->diff($protoUsers);
        foreach ($usersToRemove as $protoUser) {
            $optParams = ['domain' => 'proto.utwente.nl', 'query' => "externalId:$protoUser->id"];
            $googleUser = $this->directory->users->listUsers($optParams)->getUsers()[0];
            $this->pp(
                '<fg=red>-</> ' . str_pad("#$protoUser->id", 6) . $protoUser->name,
                fn() => $this->directory->users->delete($googleUser->id)
            );
        }

        // Loop over all active members.
        foreach ($protoUsers as $protoUser) {
            // Check if ProtoUser exists in Google Workspace.
            if ($googleUsers->contains($protoUser)) {
                $this->pp('<fg=green>✓</> ' . str_pad("#$protoUser->id", 6) . $protoUser->name);
            // Otherwise, create the Google Workspace user.
            } else {
                $this->createGoogleUser($protoUser);
            }

            // Synchronise Google Workspace groups for user.
            $this->syncGoogleGroupsForUser($protoUser);

            // Synchronise Google Workspace email aliases for user.
            $this->syncAliasesForUser($protoUser);

            // Patch user's Gmail settings.
            $this->patchGmailSettings($protoUser);
        }
    }

    public function createGoogleUser($protoUser) {
        try {
            $name = explode(' ', $protoUser->name);
            $password = Str::password();
            $this->pp(
                '<fg=yellow>+</> ' . str_pad("#$protoUser->id", 6) .
                str_pad("$protoUser->name <fg=gray>", 65, ".") . "</> pass: $password",
                fn() => $this->directory->users->insert(
                    new GoogleUser([
                        'name' => new UserName([
                            'givenName' => $name[0],
                            'familyName' => implode(' ', array_slice($name, 1)),
                            'displayName' => $protoUser->calling_name
                        ]),
                        'primaryEmail' => $protoUser->proto_email,
                        'hashFunction' => 'MD5',
                        'password' => hash('md5', $password),
                        'externalIds' => [new UserExternalId([
                            'type' => 'account',
                            'value' => $protoUser->id,
                        ])],
                    ])
                )
            );
        } catch (Throwable $e) {
            $this->pp(
                '<fg=red>x</> ' . str_pad("#$protoUser->id", 6) . $protoUser->name,
                fn() => throw $e
            );
        }
    }

    /**
     * List Google Workspace groups. Pass in user to get only their groups.
     * @param ProtoUser|null $protoUser
     * @return Collection<GoogleGroup>
     * @throws Exception
     */
    public function listGoogleGroups(ProtoUser $protoUser = null): Collection
    {
        $optParams = ['domain' => 'proto.utwente.nl'];
        if ($protoUser != null) {
            $optParams['userKey'] = $protoUser->proto_email;
        }
        $results = $this->directory->groups->listGroups($optParams);
        $pageToken = $results->getNextPageToken();
        $googleGroups = collect();
        do {
            $optParams['pageToken'] = $pageToken;
            $results = $this->directory->groups->listGroups($optParams);
            $pageToken = $results->getNextPageToken();
            $googleGroups->merge(collect($results->getGroups()));
        } while ($pageToken);
        return $googleGroups;
    }

    /**
     * List current Google Workspace users.
     * @return Collection
     * @throws Exception
     */
    public function listGoogleUsers()
    {
        $users = collect();
        $optParams = ['domain' => 'proto.utwente.nl'];
        $results = $this->directory->users->listUsers($optParams);
        $pageToken = $results->getNextPageToken();
        do {
            $optParams['pageToken'] = $pageToken;
            $results = $this->directory->users->listUsers($optParams);
            $pageToken = $results->getNextPageToken();
            foreach ($results->getUsers() as $user) {
                $id = $user->getExternalIds()[0]['value'] ?? null;
                $user = ProtoUser::find($id);
                if ($user != null) {
                    $users->push($user);
                }
            }
        } while ($pageToken);
        return $users;
    }

    /**
     * Synchronise Google Workspace groups for user.
     * @param ProtoUser $protoUser
     * @return void
     * @throws Throwable
     */
    public function syncGoogleGroupsForUser(ProtoUser $protoUser)
    {
        $indent = "        ";
        /* @var ProtoGroup $protoGroup */
        foreach ($protoUser->groups()->get() as $protoGroup) {
            try {
                if ($this->directory->members->hasMember($protoGroup->email, $protoUser->proto_email)->isMember) {
                    $this->pp($indent . '<fg=green>✓</> ' . str_pad("#$protoGroup->id", 6) . $protoGroup->name);
                } else {
                    $this->pp(
                        $indent . '<fg=yellow>+</> ' . str_pad("#$protoGroup->id", 6) . $protoGroup->name,
                        fn() => $this->directory->members->insert(
                            $protoGroup->email,
                            new GoogleGroupMembership([
                                'email' => $protoUser->proto_email,
                                'keyType' => 'USER',
                            ])
                        )
                    );
                }
            } catch (Throwable $e) {
                $this->pp(
                    $indent . '<fg=red>?</> ' . str_pad("#$protoGroup->id", 6) . $protoGroup->name,
                    fn() => throw $e
                );
            }
        }

        foreach ($this->listGoogleGroups($protoUser) as $googleGroup) {
            $protoGroup = ProtoGroup::firstWhere('slug', explode('@', $googleGroup->email)[0]);
            try {
                if ($protoGroup != null && !$protoGroup->isMember($protoUser)) {
                    $this->pp(
                        $indent . '<fg=red>-</> ' . str_pad("#$protoGroup->id", 6) . "$protoGroup->name",
                        fn() => $this->directory->members->delete($protoGroup->email, $protoUser->proto_email)
                    );
                }
            } catch (Throwable) {/* Ignored */}
        }
    }

    /**
     *
     * @param ProtoUser $protoUser
     * @return void
     * @throws Exception
     */
    public function syncAliasesForUser(ProtoUser $protoUser)
    {
        $indent = '        ';
        $googleUserAliases = $this->directory->users_aliases->listUsersAliases($protoUser->proto_email)->getAliases();
        $googleUserAliases = collect(array_column($googleUserAliases ?? [], 'alias'));
        $protoUserAliases = ProtoAlias::query()
            ->where('user_id', $protoUser->id)
            ->get()
            ->map(function ($alias) {
                return $alias->alias . '@' . config('proto.emaildomain');
            });

        foreach ($protoUserAliases->diff($googleUserAliases) as $emailAlias) {
            $this->pp(
                $indent . "<fg=yellow>+</> ✉ $emailAlias",
                fn() => $this->directory->users_aliases->insert($protoUser->proto_email, new GoogleAlias([
                    'primaryEmail' => $protoUser->proto_email,
                    'alias' => $emailAlias
                ]))
            );
        }

        foreach ($googleUserAliases->diff($protoUserAliases) as $emailAlias) {
            $this->pp(
                $indent . "<fg=red>-</> ✉ $emailAlias",
                fn() => $this->directory->users_aliases->delete($protoUser->proto_email, $emailAlias)
            );
        }
    }

    /**
     * Patch Gmail settings by impersonating a Google Workspace user.
     * @param ProtoUser $protoUser
     * @return void
     */
    public function patchGmailSettings(ProtoUser $protoUser)
    {
        $client = $this->createClient(
            $protoUser->proto_email,
            [
                'https://www.googleapis.com/auth/gmail.settings.basic',
                'https://www.googleapis.com/auth/gmail.settings.sharing',
            ]
        );
        $gmail = new Gmail($client);
        $indent = '        ';
        try {
            $gmail->users_settings_forwardingAddresses->get('me', $protoUser->email);
        } catch (Throwable) {
            $this->pp(
                $indent . "<fg=yellow>+</> ✉ $protoUser->email",
                fn() => $gmail->users_settings_forwardingAddresses->create(
                    'me',
                    new ForwardingAddress(['forwardingEmail' => $protoUser->email])
                )
            );
            return;
        }
        $this->pp(
            $indent . "<fg=green>✓</> ✉ $protoUser->email"
        );
    }
}
