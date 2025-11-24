
<?php

use App\Models\User;
use Laravel\Passport\Passport;

test('lists-user', function () {
$user = User::factory()->create();
Passport::actingAs($user, ['*']);

$response = $this->getJson(route('api::protube::'));

$response->assertOk()
    ->assertJson([
        'authenticated' => true,
        'name' => $user->calling_name,
        'admin' => false,
        'id' => $user->id,
    ])
        ->assertJsonStructure([
            'authenticated',
            'name',
            'admin',
            'id',
        ]);
});
