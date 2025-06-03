<?php


use App\Models\Member;
use App\Models\User;

it('shows the omnomcom protopolis page', function () {
    $user = User::factory()->has(Member::factory())->create()->givePermissionTo('omnomcom');
    $response = $this->actingAs($user)
        ->get(route('omnomcom::store::show', ['store' => 'protopolis']));
    $response->assertStatus(200);
    dump($response->getContent());
    $response->assertSee('Link RFID card');
});
