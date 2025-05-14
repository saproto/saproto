<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

it('allows a user to log in with valid credentials and creates a new session', function () {
    $user = User::factory()->create([
        'password' => Hash::make('password123'),
    ]);

    $sessionIdBeforeLogin = session()->getId();

    $loginData = [
        'email' => $user->email,
        'password' => 'password123',
    ];

    // login
    $response = $this->post(route('login::post'), $loginData);

    $this->assertAuthenticatedAs($user);

    $this->assertNotEquals($sessionIdBeforeLogin, session()->getId());

    $response->assertRedirect('/');
});

it('does not allow login with invalid credentials', function () {
    $user = User::factory()->create([
        'password' => Hash::make('password123'),
    ]);

    $invalidLoginData = [
        'email' => $user->email,
        'password' => 'wrongpassword',
    ];

    // login with invalid credentials
    $response = $this->post(route('login::post'), $invalidLoginData);

    $response->assertRedirect(route('login::show'));
    $this->assertGuest();

    $response->assertSessionHas('flash_message', 'Invalid username or password provided.');
});

it('logs out an authenticated user and invalidates the session', function () {
    $user = User::factory()->create([
        'password' => Hash::make('password123'),
    ]);

    $this->actingAs($user);

    $sessionIdBeforeLogout = session()->getId();

    //logout
    $response = $this->post(route('login::logout'));

    $response->assertRedirect('/');

    // Assert that the user is logged out
    $this->assertGuest();

    // Assert that the session ID has changed, indicating that the session was invalidated
    $this->assertNotEquals($sessionIdBeforeLogout, session()->getId());

    $response->assertSessionHas('flash_message', 'You have been logged out.');
});
