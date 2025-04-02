<?php

use App\Enums\VisibilityEnum;
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
        'visibility'=> VisibilityEnum::SECRET,
        'start' => Carbon::now()->addDay(),
        'end' => Carbon::now()->addDays(2),
    ]), 'This event is not shown on the site'],
    'unpublished' => [fn () => Event::factory()->create([
        'start' => Carbon::now()->addDay(),
        'end' => Carbon::now()->addDays(2),
        'publication' => Carbon::now()->addHours(2),
        'visibility'=> VisibilityEnum::SCHEDULED,
    ]), 'This event is scheduled'],
]);

dataset('public events', [
    'normal' => [fn () => Event::factory()->create([
        'start' => Carbon::now()->addDay(),
        'end' => Carbon::now()->addDays(2),
    ])],
    'published' => [fn () => Event::factory()->create([
        'start' => Carbon::now()->addDay(),
        'end' => Carbon::now()->addDays(2),
        'visibility'=> VisibilityEnum::SCHEDULED,
        'publication' => Carbon::now()->subHours(2),
    ])],
]);

it('lets everyone see non secret events', function (User $user, bool $unimportant, Event $event) {

    $response = $this->actingAs($user)
        ->get(route('event::show', ['id' => $event->getPublicId()]));

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
        ->get(route('event::show', ['id' => $event->getPublicId()]));

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
