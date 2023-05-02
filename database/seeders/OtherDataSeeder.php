<?php

namespace Database\Seeders;

use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use Proto\Models\AchievementOwnership;
use Proto\Models\Activity;
use Proto\Models\ActivityParticipation;
use Proto\Models\Address;
use Proto\Models\Bank;
use Proto\Models\Committee;
use Proto\Models\CommitteeMembership;
use Proto\Models\Feedback;
use Proto\Models\HashMapItem;
use Proto\Models\Member;
use Proto\Models\OrderLine;
use Proto\Models\Page;
use Proto\Models\Quote;
use Proto\Models\User;

class OtherDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run($output)
    {
        $output->info('Seeding fake data');

        // Create users
        $n = 10;
        $output->task("creating $n regular users", function () use ($n) {
            $users = User::factory()->count($n)->create();
            foreach($users as $user) {
                if (fake()->boolean(30)) {
                    Address::factory()->for($user)->create();
                }
                if (fake()->boolean(30)) {
                    Bank::factory()->for($user)->create();
                }
            }
        });

        // Create members
        $n = 90;
        $output->task("creating $n members", function () use ($n) {
            Member::factory()
                ->count($n - 5)
                ->create();

            Member::factory()
                ->count(4)
                ->state(new Sequence(
                    ['is_lifelong' => 1],
                    ['is_honorary' => 1],
                    ['is_donor' => 1],
                    ['is_pet' => 1],
                ))
                ->state([
                    'is_pending' => 0,
                    'deleted_at' => null,
                ])
                ->create();
        });

        // Get users with completed membership
        $members = User::whereHas('member', fn ($members) => $members->where('is_pending', '==', false))->get();

        // Create committee participations
        $committees = Committee::all();
        $output->task('creating committee memberships', function () use ($members, $committees) {
            foreach($committees as $committee) {
                $n = fake()->numberBetween(1, $members->count() / 2);
                foreach($members->random($n) as $member) {
                    CommitteeMembership::factory()
                        ->for($member)
                        ->for($committee)
                        ->create();
                }
            }
        });

        // Create orderlines
        $output->task('creating orderlines', function () use ($members) {
            foreach($members as $member) {
                OrderLine::factory()
                    ->count(fake()->randomDigit())
                    ->for($member)
                    ->create();
            }
        });


        $quotes = new \Proto\Models\FeedbackCategory([
            'title'=>'Quotes',
            'url'=>'quotes',
            'review'=>false,
        ]);
        $quotes->save();

        // Create Quotes
        $n = 200;
        $time_start = microtime(true);

        foreach (range(1, $n) as $index) {

            $quote = new Feedback([
                'user_id'=> array_random($users),
                'feedback'=>$faker->text(100),
                'feedback_category_id'=>2,
            ]);
            $quote->save();
            echo "\e[33mCreating:\e[0m  ".$index.'/'.$n." quotes\r";
        }

        $time_end = microtime(true);
        echo PHP_EOL."\e[32mCreated:\e[0m   ".$n.' quotes '.'('.round(($time_end - $time_start), 2).'s)'.PHP_EOL;
        // Create AchievementOwnership
        $output->task('creating achievement ownerships', function () use ($members) {
            foreach($members as $member) {
                AchievementOwnership::factory()
                    ->count(fake()->randomDigit())
                    ->for($member)
                    ->create();
            }
        });

        // Create activity participations
        $output->task('creating activity participations', function () use ($members) {
            $activities = Activity::has('event')->orderBy('id', 'desc')->take(25)->get();
            foreach($activities as $activity) {
                $n = fake()->numberBetween(1, $members->count());
                foreach($members->random($n) as $member) {
                    ActivityParticipation::factory()
                        ->state(['activity_id' => $activity->id])
                        ->for($member)
                        ->create();
                }
            }
        });

        // Create pages
        $n = 10;
        $output->task("creating $n pages", fn () => Page::factory()->count($n)->create());

        // Create quotes
        $n = 100;
        $output->task("creating $n quotes", fn () => Quote::factory()->count($n)->create());

        // Create GoodIdeas
        $n = 200;

        $time_start = microtime(true);

        foreach (range(1, $n) as $index) {
            $goodIdea = new Feedback([
                'user_id'=> array_random($users),
                'feedback'=>$faker->text(50),
                'feedback_category_id'=>1,
            ]);
            $goodIdea->save();

            echo "\e[33mCreating:\e[0m  ".$index.'/'.$n." goodIdeas\r";
        }

        $time_end = microtime(true);
        echo PHP_EOL."\e[32mCreated:\e[0m   ".$n.' quotes '.'('.round(($time_end - $time_start), 2).'s)'.PHP_EOL;

        // Create newsletter text
        $output->task('creating newsletter', function () use ($members) {
            HashMapItem::factory()->text()->create(['key' => 'newsletter_text']);
            HashMapItem::factory()->date()->create(['key' => 'newsletter_text_updated', ]);
            HashMapItem::factory()->date()->create(['key' => 'newsletter_last_sent']);
        });
    }
}
