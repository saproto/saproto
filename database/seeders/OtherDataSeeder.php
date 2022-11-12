<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Proto\Models\AchievementOwnership;
use Proto\Models\Activity;
use Proto\Models\ActivityParticipation;
use Proto\Models\Address;
use Proto\Models\Bank;
use Proto\Models\Committee;
use Proto\Models\CommitteeMembership;
use Proto\Models\HashMapItem;
use Proto\Models\Member;
use Proto\Models\OrderLine;
use Proto\Models\User;
use Proto\Models\Withdrawal;

class OtherDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        echo "\e[33mSeeding:\e[0m   \e[1mOtherDataSeeder\e[0m".PHP_EOL;
        $seeder_start = microtime(true);

        // Create users
        $n = 100;
        $time_start = microtime(true);

        foreach (range(1, $n) as $index) {
            /** @var $user User */
            $user = factory(User::class)->create();

            // user is a member
            if (mt_rand(1, 5) > 1) {
                $user->bank()->save(factory(Bank::class)->make());
                $user->address()->save(factory(Address::class)->make());
                $user->member()->save(factory(Member::class)->make());
            } // user is not a member
            else {
                if (mt_rand(1, 20) > 15) {
                    $user->address()->save(factory(Address::class)->make());
                }

                if (mt_rand(1, 20) > 15) {
                    $user->bank()->save(factory(Bank::class)->make());
                }
            }

            echo "\e[33mCreating:\e[0m  ".$index.'/'.$n." users\r";
        }

        $time_end = microtime(true);
        echo PHP_EOL."\e[32mCreated:\e[0m   ".$n.' users '.'('.round(($time_end - $time_start), 2).'s)'.PHP_EOL;

        // Create arrays of member user ids
        $users = User::whereHas('member', function ($q) {
            $q->where('is_pending', '=', false);
        })->pluck('id')->toArray();

        // Create orderlines
        $n = 1000;
        $time_start = microtime(true);

        foreach (range(1, $n) as $index) {
            factory(Orderline::class)->create([
                'user_id' => array_random($users),
            ]);
            echo "\e[33mCreating:\e[0m  ".$index.'/'.$n." orderlines\r";
        }

        $time_end = microtime(true);
        echo PHP_EOL."\e[32mCreated:\e[0m   ".$n.' orderlines '.'('.round(($time_end - $time_start), 2).'s)'.PHP_EOL;

        // Create withdrawals
        $n = 2;
        $orderlines_per_withdrawal = 5;
        $max_withdrawal_amount = 100;
        $orderlines_associated = 0;

        $time_start = microtime(true);

        foreach (range(1,$n) as $index){
            $orderlines_associated += $this->seedWithdrawals($index, $max_withdrawal_amount,$orderlines_per_withdrawal);
        }
        $time_end = microtime(true);
        echo PHP_EOL."\e[32mAssociated:\e[0m  ".$orderlines_associated.' orderlines to '.$n.' rounds of withdrawals'.'('.round(($time_end - $time_start), 2).'s)'.PHP_EOL;

        // Create AchievementOwnership
        $n = 200;
        $time_start = microtime(true);

        foreach (range(1, $n) as $index) {
            factory(AchievementOwnership::class)->create([
                'user_id' => array_random($users),
            ]);
            echo "\e[33mCreating:\e[0m  ".$index.'/'.$n." achievement ownerships\r";
        }

        $time_end = microtime(true);
        echo PHP_EOL."\e[32mCreated:\e[0m   ".$n.' achievement ownerships '.'('.round(($time_end - $time_start), 2).'s)'.PHP_EOL;

        // Create committee participations
        $n = 50;
        $time_start = microtime(true);
        $committees = Committee::all()->pluck('id')->toArray();

        foreach (range(1, $n) as $index) {
            factory(CommitteeMembership::class, $n)->create([
                'user_id' => array_random($users),
                'committee_id' => array_random($committees),
            ]);

            echo "\e[33mCreating:\e[0m  ".$index.'/'.$n." committee memberships\r";
        }

        $time_end = microtime(true);
        echo PHP_EOL."\e[32mCreated:\e[0m   ".$n.' committee memberships '.'('.round(($time_end - $time_start), 2).'s)'.PHP_EOL;

        // Create activity participations
        echo "\e[33mCreating:\e[0m  activity participations".PHP_EOL;
        $time_start = microtime(true);

        foreach (Activity::orderBy('id', 'desc')->take(25)->get() as $activity) {
            if (! $activity->event) {
                continue;
            }

            $mintime = date('U', strtotime($activity->registration_start));
            $maxtime = date('U', strtotime($activity->event->start));

            $offset = mt_rand(-15, 5);
            $max = ($activity->participants < 0 ? mt_rand(0, 50) : $activity->participants);
            $p = (max($max + $offset, 0));

            $j = 0;
            for ($i = 0; $i < $p; $i++) {
                $startDate = date('U', ($maxtime > $mintime ? mt_rand($mintime, $maxtime) : $mintime));
                $endDate = date('Y-m-d H:i:s', ($maxtime > $startDate ? mt_rand($startDate, $maxtime) : $maxtime));

                ActivityParticipation::create([
                    'user_id' => array_random($users),
                    'activity_id' => $activity->id,
                    'created_at' => date('Y-m-d H:i:s', $startDate),
                    'deleted_at' => (mt_rand(1, 3) == 1 ? $endDate : null),
                    'backup' => ($activity->participants != -1 && $j > $activity->participants),
                ]);

                $j++;
            }
        }

        $time_end = microtime(true);
        echo "\e[32mCreated:\e[0m   activity participations ".'('.round(($time_end - $time_start), 2).'s)'.PHP_EOL;

        // Create newsletter text
        echo "\e[33mCreating:\e[0m  newsletter text".PHP_EOL;
        $time_start = microtime(true);
        HashMapItem::create(['key' => 'newsletter_text', 'value' => $faker->text(400)]);
        HashMapItem::create(['key' => 'newsletter_text_updated', 'value' => date('U')]);
        HashMapItem::create(['key' => 'newsletter_last_sent', 'value' => date('U')]);
        $time_end = microtime(true);
        echo "\e[32mCreated:\e[0m   newsletter text ".'('.round(($time_end - $time_start), 2).'s)'.PHP_EOL;

        $seeder_end = microtime(true);
        echo "\e[32mSeeded:\e[0m    \e[1mOtherDataSeeder\e[0m (".round(($seeder_end - $seeder_start), 2).'s)'.PHP_EOL;
    }

    // Withdrawal seeding helper method, based on store() method in WithdrawalController.php
    // NOTE: Any updates in that method should be mirrorred in here
    public function seedWithdrawals(int $index, int $maxMoney, int $maxOrderlinesInWithdrawal): int
    {
        $totalOrderlinesAdded = 0;

        $date = strtotime('now');

        $withdrawal = Withdrawal::create([
            'date' => date('Y-m-d', $date),
        ]);

        $totalOrderlinesPerUser = [];
        $totalPerUser = [];

        foreach (OrderLine::whereNull('payed_with_withdrawal')->get() as $orderline) {
            if ($orderline->isPayed()) {
                continue;
            }
            if ($orderline->user === null) {
                continue;
            }
            if ($orderline->user->bank == null) {
                continue;
            }

            if (! array_key_exists($orderline->user->id, $totalPerUser)) {
                $totalPerUser[$orderline->user->id] = 0;
            }

            if (! array_key_exists($orderline->user->id, $totalOrderlinesPerUser)) {
                $totalOrderlinesPerUser[$orderline->user->id] = 0;
            }
            if ($totalPerUser[$orderline->user->id] + $orderline->total_price > $maxMoney) {
                continue;
            }

            if($totalOrderlinesPerUser[$orderline->user->id] >= $maxOrderlinesInWithdrawal){
                continue;
            }

            $orderline->withdrawal()->associate($withdrawal);
            $orderline->save();

            $totalOrderlinesAdded++;

            $totalPerUser[$orderline->user->id] += $orderline->total_price;
            $totalOrderlinesPerUser[$orderline->user->id] += 1;

            echo "\e[32mCollecting:\e[0m  ".$totalOrderlinesAdded.' orderlines into withdrawal set '.$index."\r";
        }

        // Prevent negative withdrawals
        foreach ($totalPerUser as $user_id => $total) {
            if ($total < 0) {
                /** @var User $user */
                $user = User::findOrFail($user_id);
                foreach ($withdrawal->orderlinesForUser($user) as $orderline) {
                    $orderline->withdrawal()->dissociate();
                    $orderline->save();

                    $totalOrderlinesAdded--;
                    echo "\e[33mReducing:\e[0m  The amount of orderlines in withdrawal round ".$index.'to'.$totalOrderlinesAdded." orderlines \r";
                }
            }
        }
        return $totalOrderlinesAdded;
    }
}
