<?php

namespace Database\Seeders;

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
        // Create users
        $n = 100;
        $output->task("creating $n users", function () use ($n) {
            $users = User::factory()
                ->count($n)
                ->create();
            foreach($users->random(mt_rand($n / 2, $n)) as $user) {
                Bank::factory()
                    ->for($user)
                    ->create();
            }
            foreach($users->random(mt_rand($n / 2, $n)) as $user) {
                Address::factory()
                    ->for($user)
                    ->create();
            }
        });

        // Create members
        $users = User::has('bank')->has('address')->get();
        $n = $users->count();
        $output->task("creating $n members", function () use ($n, $users) {
            foreach($users->random(mt_rand($n / 2, $n)) as $user) {
                Member::factory()
                    ->for($user)
                    ->create();
            }
        });

        // Get users with completed membership
        $members = User::whereHas('member', fn ($members) => $members->where('is_pending', '==', false))->get();

        // Create committee participations
        $committees = Committee::all();
        $output->task('Creating committee memberships', function () use ($members, $committees) {
            foreach($committees as $committee) {
                foreach($members->random(mt_rand(1, $members->count())) as $member) {
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
                    ->count(mt_rand(0, 10))
                    ->for($member)
                    ->create();
            }
        });

        // Create AchievementOwnership
        $output->task('creating achievement ownerships', function () use ($members) {
            foreach($members as $member){
                AchievementOwnership::factory()
                    ->count(mt_rand(0, 10))
                    ->for($member)
                    ->create();
            }
        });

        // Create activity participations
        $output->task('creating activity participations', function () use ($members) {
            $activities = Activity::has('event')->orderBy('id', 'desc')->take(25)->get();
            foreach($activities as $activity) {
                foreach($members->random(mt_rand(1, $members->count())) as $member) {
                    ActivityParticipation::factory()->for($activity)->for($member);
                }
            }
        });

        // Create AchievementOwnership
        $output->task('creating activity participations', function () use ($members) {
            $activities = Activity::has('event')->orderBy('id', 'desc')->take(25)->get();
            foreach($activities as $activity) {
                foreach($members->random(fake()->numberBetween(0, $members->count())) as $member) {
                    ActivityParticipation::factory()->for($activity)->for($member);
                }
            }
        });

        // Create newsletter text
        $output->task('creating newsletter', function () use ($members) {
            HashMapItem::factory()->text()->create(['key' => 'newsletter_text']);
            HashMapItem::factory()->date()->create(['key' => 'newsletter_text_updated', ]);
            HashMapItem::factory()->date()->create(['key' => 'newsletter_last_sent']);
        });
    }
}
