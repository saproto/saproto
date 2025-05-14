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
    // Create a user with a password
    $user = User::factory()->create([
        'password' => Hash::make('password123'), // Hash the password
    ]);

    // Log the user in
    $this->actingAs($user);

    // Get the current session ID (before logout)
    $sessionIdBeforeLogout = session()->getId();

    // Perform the logout action
    $response = $this->post(route('login::logout'));

    $response->assertRedirect('/');  // Ensure redirection occurs to homepage or other page

    // Assert that the user is logged out (the session should no longer have the user)
    $this->assertGuest();  // Ensure the user is not authenticated

    // Assert that the session ID has changed, indicating that the session was invalidated
    $this->assertNotEquals($sessionIdBeforeLogout, session()->getId());  // Session ID should be different after logout

    // Optionally, check if a flash message is displayed indicating successful logout
    $response->assertSessionHas('flash_message', 'You have been logged out.');
});
