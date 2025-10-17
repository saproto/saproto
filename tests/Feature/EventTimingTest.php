<?php

use App\Models\Activity;
use App\Models\Event;
use App\Models\Member;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Date;

use function PHPUnit\Framework\assertTrue;

$t0 = Date::create(2000, 1, 1, 12, 0, 0, 0);

dataset('models', [
    'model' => [
        function () use ($t0) {
            $event = Event::factory()->has(Activity::factory())->create([
                'secret' => false,
                'start' => $t0->copy()->addDay()->timestamp,
                'end' => $t0->copy()->addDays(2)->timestamp,
            ]);

            $event->activity->update([
                'registration_start' => $t0->copy()->timestamp,
                'registration_end' => $t0->copy()->addDay()->timestamp,
                'deregistration_end' => $t0->copy()->addDays(2)->timestamp,
                'participants' => -1,
            ]);

            return $event;
        },
        fn () => User::factory()->has(Member::factory())->create(),
    ],
]);

dataset('times', [
    // before opening time
    'm2000ms' => $t0->copy()->addMilliseconds(-2000),
    'm1000ms' => $t0->copy()->addMilliseconds(-1000),
    'm500ms' => $t0->copy()->addMilliseconds(-500),
    'm250ms' => $t0->copy()->addMilliseconds(-250),
    'm100ms' => $t0->copy()->addMilliseconds(-100),
    'm50ms' => $t0->copy()->addMilliseconds(-50),
    'm25ms' => $t0->copy()->addMilliseconds(-25),
    // exactly on opening time
    't0' => $t0->copy(),
    // after opening time
    'p50ms' => $t0->copy()->addMilliseconds(50),
    'p100ms' => $t0->copy()->addMilliseconds(100),
    'p250ms' => $t0->copy()->addMilliseconds(250),
    'p500ms' => $t0->copy()->addMilliseconds(500),
    'p1000ms' => $t0->copy()->addMilliseconds(1000),
    'p2000ms' => $t0->copy()->addMilliseconds(2000),
]);

it('rejects participations before the signup opening', function (Carbon $time, Event $event, User $user) use ($t0) {
    if ($time->isBefore($t0)) {
        Date::withTestNow($time, function () use ($user, $event) {
            $response = $this->actingAs($user)->get(
                route('event::addparticipation', ['event' => $event]));
            $response->assertStatus(403);
            $response->assertDontSee('You claimed a spot for');
            $response->assertDontSee('You have been placed on the back-up list for');
            $response->assertSee('You cannot subscribe for '.$event->title.' at this time');
        });
    } else {
        // Skip for this test
        assertTrue(true);
    }
})->with('times')->with('models');

it('allows participation when open', function (Carbon $time, Event $event, User $user) use ($t0) {
    if ($time->isAfter($t0) || $time->equalTo($t0)) {
        Date::withTestNow($time, function () use ($user, $event) {
            $response = $this->actingAs($user)->get(
                route('event::addparticipation', ['event' => $event]));
            $response->assertRedirect();

            $redirectUrl = $response->headers->get('Location');
            $response = $this->actingAs($user)->get($redirectUrl);
            $response->assertSee('You claimed a spot for');
            $response->assertDontSee('You have been placed on the back-up list for');
            $response->assertDontSee('You cannot subscribe');
        });
    } else {
        // Skip for this test
        assertTrue(true);
    }

})->with('times')->with('models');
