<?php

use Illuminate\Database\Seeder;

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

        // List of valid ID's
        $products = Product::all()->pluck('id')->toArray();
        $committees = Committee::all()->pluck('id')->toArray();

        // Create users
        $n = 500;
        echo "Creating $n users" . PHP_EOL;
        factory(User::class, $n)->create()->each(function ($u) {
            if (mt_rand(1, 5) > 1) {
                $u->address()->save(factory(Address::class)->make());
            }
            if (mt_rand(1, 5) > 1) {
                $u->bank()->save(factory(Bank::class)->make());
            }
            if (mt_rand(1, 5) > 1) {
                $u->member()->save(factory(Member::class)->make());
            }
        });

        $users = array_merge(array_rand(User::all()->pluck('id')->toArray(), 75), [1]);

        // Create orderlines
        $n = 10000;
        echo "Creating $n orderlines" . PHP_EOL;

        $mintime = date('U', strtotime('April 20, 2011'));
        $maxtime = date('U', strtotime('now'));

        for ($i = 0; $i < $n; $i++) {
            $p = Product::find($products[array_rand($products)]);
            $d = date('Y-m-d H:i:s', mt_rand($mintime, $maxtime));
            $u = mt_rand(1, 3);
            $data = [
                'user_id' => $users[array_rand($users)],
                'product_id' => $p->id,
                'original_unit_price' => $p->price,
                'units' => $u,
                'total_price' => $u * $p->price,
                'created_at' => $d
            ];

            if (mt_rand(1, 100) == 1) {
                // Simulate Pay via Cash
                $data['cashier_id'] = $users[array_rand($users)];
                $data['payed_with_cash'] = $d;
            }
            OrderLine::create($data);
        }

        // Create committee participations
        $n = 1000;
        echo "Creating $n committee participations" . PHP_EOL;
        $maxtime = date('U', strtotime('+1 year'));

        for ($i = 0; $i < $n; $i++) {
            $c = Committee::find($committees[array_rand($committees)]);
            $d = [date('Y-m-d H:i:s', mt_rand($mintime, $maxtime)), date('Y-m-d H:i:s', mt_rand($mintime, $maxtime))];
            if ($d[0] < $d[1]) {
                $sd = $d[0];
                $ed = $d[1];
            } else {
                $sd = $d[1];
                $ed = $d[0];
            }

            CommitteeMembership::create([
                'user_id' => $users[array_rand($users)],
                'committee_id' => $committees[array_rand($committees)],
                'role' => 'Automatically Added',
                'edition' => (mt_rand(1, 2) == 1 ? mt_rand(1, 5) : null),
                'created_at' => $sd,
                'deleted_at' => (mt_rand(1, 3) == 1 ? $ed : null)
            ]);
        }

        // Create activity participations

        $users = User::all()->pluck('id')->toArray();
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
                $d = date('Y-m-d H:i:s', ($maxtime > $mintime ? mt_rand($mintime, $maxtime) : $mintime));

                ActivityParticipation::create([
                    'user_id' => $users[array_rand($users)],
                    'activity_id' => $activity->id,
                    'created_at' => $d,
                    'deleted_at' => (mt_rand(1, 3) == 1 ? $ed : null),
                    'backup' => ($activity->participants != -1 && $j > $activity->participants)
                ]);

                $j++;
            }
        }

    }
}
