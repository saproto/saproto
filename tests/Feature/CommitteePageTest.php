<?php

use App\Models\Committee;
use App\Models\Event;
use App\Models\Member;

it('shows the committee page with previous events', function () {
    $member = Member::factory()->create();

    $event = Event::factory()->has(Committee::factory())->create([
        'publication' => time() - 1000,
        'end' => time() - 500,
    ]);

    $response = $this->actingAs($member->user)
        ->get(route('committee::show', ['id' => $event->committee->slug]));

    $response->assertSee($event->committee->name);

    $response->assertSee($event->title);
});
