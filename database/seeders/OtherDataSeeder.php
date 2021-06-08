<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;

use Proto\Models\HashMapItem;
use Proto\Models\MenuItem;
use Proto\Models\Page;
use Proto\Models\User;
use Proto\Models\Committee;
use Proto\Models\Address;
use Proto\Models\Bank;
use Proto\Models\Member;
use Proto\Models\Activity;
use Proto\Models\OrderLine;
use Proto\Models\CommitteeMembership;
use Proto\Models\ActivityParticipation;

class OtherDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create parent menu items
        MenuItem::create([
            'menuname' => "public pages",
            'order' => 0,
            'is_member_only' => 0,
        ]);

        MenuItem::create([
            'menuname' => "member pages",
            'order' => 1,
            'is_member_only' => 1,
        ]);

        // Create pages
        $n = 10;
        echo "Creating $n pages" . PHP_EOL;
        foreach(range(1, $n) as $index) {
            $page = Page::factory()->create();

            MenuItem::create([
                'parent' => $page->is_member_only + 1,
                'menuname' => $page->title,
                'page_id' => $page->id,
                'order' => $index + 1,
                'is_member_only' => $page->is_member_only,
            ]);
        }

        // Create users
        $n = 100;

        foreach(range(1, $n) as $index) {
            /** @var $user User */
            $user = User::factory()->create();

                // user is a member
                if (mt_rand(1, 5) > 1) {
                    $user->bank()->save(Bank::factory()->create());
                    $user->address()->save(Address::factory()->create());
                    $user->member()->save(Member::factory()->create());
                }

                // user is not a member
                else {
                    if (mt_rand(1, 20) > 15) {
                        $user->address()->save(Address::factory()->create());
                    }

                    if (mt_rand(1, 20) > 15) {
                        $user->bank()->save(Bank::factory()->create());
                    }
                }

            echo "Creating " . $index . "/" . $n . " users\r";
        }

        echo PHP_EOL;

        // Create arrays of member user ids
        $users = User::whereHas('member', function($q){ $q->where('pending', '=', 0); })->pluck('id')->toArray();

        // Create orderlines
        $n = 1000;

        foreach(range(1, $n) as $index) {
            Orderline::factory()->create([
                'user_id' => array_random($users),
            ]);
            echo "Creating " . $index . "/" . $n . " orderlines\r";
        }

        echo PHP_EOL;

        // Create committee participations
        $n = 50;
        $committees = Committee::all()->pluck('id')->toArray();

        foreach(range(1, $n) as $index) {
            CommitteeMembership::factory()->create([
                'user_id' => array_random($users),
                'committee_id' => array_random($committees),
            ]);

            echo "Creating " . $index . "/" . $n . " committee memberships\r";
        }

        echo PHP_EOL;

        // Create activity participations
        echo "Creating activity participations" . PHP_EOL;

        foreach (Activity::orderBy('id', 'desc')->take(25)->get() as $activity) {
            if (!$activity->event) continue;

            $mintime = date('U', strtotime($activity->registration_start));
            $maxtime = date('U', strtotime($activity->event->start));

            $offset = mt_rand(-15, 5);
            $max = ($activity->participants < 0 ? mt_rand(0, 50) : $activity->participants);
            $p = ($max + $offset < 0 ? 0 : $max + $offset);

            $j = 0;
            for ($i = 0; $i < $p; $i++) {
                $startDate = date('U', ($maxtime > $mintime ? mt_rand($mintime, $maxtime) : $mintime));
                $endDate = date('Y-m-d H:i:s', ($maxtime > $startDate ? mt_rand($startDate, $maxtime) : $maxtime));

                ActivityParticipation::create([
                    'user_id' => array_random($users),
                    'activity_id' => $activity->id,
                    'created_at' => date('Y-m-d H:i:s', $startDate),
                    'deleted_at' => (mt_rand(1, 3) == 1 ? $endDate : null),
                    'backup' => ($activity->participants != -1 && $j > $activity->participants)
                ]);

                $j++;
            }
        }

        $faker = Factory::create();

        // Create newsletter text
        echo "Creating newsletter text" . PHP_EOL;
        HashMapItem::create(['key' => 'newsletter_text', 'value' => $faker->text(400)]);
        HashMapItem::create(['key' => 'newsletter_text_updated', 'value' => date('U')]);
        HashMapItem::create(['key' => 'newsletter_last_sent', 'value' => date('U')]);
    }
}