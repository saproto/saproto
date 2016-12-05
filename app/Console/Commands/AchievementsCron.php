<?php

namespace Proto\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

use Proto\Models\Achievement;
use Proto\Models\User;
use Proto\Models\AchievementOwnership;

use Proto\Http\Controllers\UserAchievementController;

class AchievementsCron extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'proto:achievementscron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cronjob that automatically assigns achievements';

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
        $this->info('Autoassigning achievements to users...');

        $changecount = 0;

        $achievements = Achievement::all();

        foreach ($achievements as $achievement) {

            if ($achievement->automatic) {

                $users = DB::select($achievement->query);

                foreach ($users as $user_id) {

                    if (property_exists($user_id, 'user_id')) {
                        $user = User::find($user_id->user_id);
                    } else if (property_exists($user_id, 'id')) {
                        $user = User::find($user_id->id);
                    }

                    if ($user) {
                        $this->info('Checking:');
                        $this->info($user->name);

                        $achieved = $user->achieved();
                        $hasAchievement = false;

                        foreach ($achieved as $test) {
                            if ($test->id == $achievement->id) {
                                $hasAchievement = true;
                                break;
                            }
                        }

                        if (!$hasAchievement) {
                            $new = array(
                                'user_id' => $user->id,
                                'achievement_id' => $achievement->id
                            );
                            $relation = new AchievementOwnership($new);
                            $relation->save();
                            $changecount += 1;
                            $this->info('Achievement "' . $achievement->name . '" given to ' . $user->name);
                        }
                    } else {
                        $this->error('Couldnt find a certain user for query ' . $achievement->query);
                    }

                }

            }

        }

        $this->info('Done! Gave away ' . $changecount . ' achievements.');

    }

}
