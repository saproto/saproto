<?php

use App\Models\Event;
use App\Models\Member;
use App\Models\User;

dataset('users', [
    'user' => [fn () => User::factory()->create(), false],
    'member' => [fn () => User::factory()->has(Member::factory())->create(), false],
    'board' => [fn () => User::factory()->has(Member::factory())->create()->givePermissionTo('board'), true],
]);

dataset('private events', [
    'secret' => [fn () => Event::factory()->create([
        'secret' => true,
        'start' => Carbon::now()->addDay()->timestamp,
        'end' => Carbon::now()->addDays(2)->timestamp,
    ]), 'This event is not shown on the site'],
    'unpublished' => [fn () => Event::factory()->create([
        'secret' => false,
        'start' => Carbon::now()->addDay()->timestamp,
        'end' => Carbon::now()->addDays(2)->timestamp,
        'publication' => Carbon::now()->addHours(2)->timestamp,
    ]), 'This event is scheduled'],
]);

dataset('public events', [
    'normal' => [fn () => Event::factory()->create([
        'secret' => false,
        'start' => Carbon::now()->addDay()->timestamp,
        'end' => Carbon::now()->addDays(2)->timestamp,
    ])],
    'published' => [fn () => Event::factory()->create([
        'secret' => false,
        'start' => Carbon::now()->addDay()->timestamp,
        'end' => Carbon::now()->addDays(2)->timestamp,
        'publication' => Carbon::now()->subHours(2)->timestamp,
    ])],
]);

it('lets everyone see non secret events', function (User $user, bool $unimportant, Event $event) {

    $response = $this->actingAs($user)
        ->get(route('event::show', ['event' => $event]));

    $response->assertSee($event->title);
    $response->assertSee($event->location);
    $response->assertDontSee('This event is not shown on the site');
    $response->assertDontSee('This event is scheduled');

    $response = $this->actingAs($user)
        ->get(route('event::index'));
    $response->assertStatus(200);

    $response->assertSee($event->title);

    $response->assertStatus(200);
})->with('users')->with('public events');

it('lets everyone see the right events', function (User $user, bool $canSeeEventInOverview, Event $event, string $message) {
    $response = $this->actingAs($user)
        ->get(route('event::show', ['event' => $event]));

    $response->assertStatus(200);
    $response->assertSee($event->title);
    $response->assertSee($message);

    $response = $this->actingAs($user)
        ->get(route('event::index'));
    $response->assertStatus(200);

    if ($canSeeEventInOverview) {
        $response->assertSee($event->title);
    } else {
        $response->assertDontSee($event->title);
    }
})->with('users', 'private events');
