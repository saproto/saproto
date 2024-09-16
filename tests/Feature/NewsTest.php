<?php

use App\Models\Member;

it('shows members the news section on the homepage', function () {
    $member = Member::factory()->create();
    $response = $this->actingAs($member->user)
        ->get('/');

    $response->assertSee('View older news');
    $response->assertSee('cucumber time');
    $response->assertStatus(200);
});

it('shows members an empty news page', function () {
    $member = Member::factory()->create();
    $response = $this->actingAs($member->user)
        ->get('/news/list');

    $response->assertSee('no News Articles');
    $response->assertStatus(200);
});
