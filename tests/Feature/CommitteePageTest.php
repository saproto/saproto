<?php


use App\Models\Committee;
use App\Models\Event;
use App\Models\Member;

it('shows the committee page with previous events', function () {
    $member = Member::factory()->create();

    $committee = Committee::factory()->create();

    $event = Event::factory()->create([
        'committee_id' => $committee->id,
        'publication' => time() - 1000,
        'end' => time() - 500,
    ]);

    $response = $this->actingAs($member->user)
        ->get(route('committee::show', ['id' => $committee->slug]));

    $response->assertSee($committee->name);

    $response->assertSee($event->title);
});
