<?php

use App\Models\Committee;
use App\Models\Event;
use App\Models\Member;
use App\Models\User;
use Illuminate\Support\Carbon;

it('shows the committee page with previous events', function () {
    $user = User::factory()->has(Member::factory())->create();

    $event = Event::factory()->has(Committee::factory([
        'public' => true,
    ]))->create([
        'secret' => false,
        'end' => Carbon::now()->getTimestamp() - 500,
    ]);

    $response = $this->actingAs($user)
        ->get(route('committee::show', ['id' => $event->committee->slug]));

    $response->assertSee($event->committee->name);

    $response->assertSee($event->title);
});
