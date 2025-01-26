<?php

use App\Models\Member;

it('renders the user admin page', function () {
    /** @var Member $member */
    $member = Member::factory()->create();
    $member->user->assignRole('board');
    $response = $this->actingAs($member->user)
        ->get(route('user::admin::details', ['id' => $member->user->id]));
    $response->assertStatus(200);
    $response->assertSee("Contact details for {$member->user->calling_name}");
});
