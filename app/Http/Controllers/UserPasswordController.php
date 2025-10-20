<?php

namespace App\Http\Controllers;

use App\Models\PasswordReset;
use App\Models\User;
use Exception;
use Google\Service\Directory;
use Google\Service\Directory\User as GoogleUser;
use Google_Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class UserPasswordController extends Controller
{
    /**
     * Show the page to request a password reset via an email.
     */
    public function requestPasswordResetIndex(): View
    {
        return view('auth.passreset_mail');
    }

    /**
     * Send an email with a password reset link to the user if found.
     */
    public function requestPasswordReset(Request $request): RedirectResponse
    {
        $user = User::query()->where('email', $request->email)->first();
        $user?->sendPasswordResetEmail();

        Session::flash('flash_message', 'If an account exists at this e-mail address, you will receive an e-mail with instructions to reset your password.');

        return to_route('login::show');
    }

    /**
     * Show the page to reset the password.
     *
     * @param  string  $token  The reset token, as e-mailed to the user.
     */
    public function resetPasswordIndex(string $token): RedirectResponse|View
    {
        PasswordReset::query()->where('valid_to', '<', Carbon::now()->timestamp)->delete();
        $reset = PasswordReset::query()->where('token', $token)->first();
        if ($reset !== null) {
            return view('auth.passreset_pass', ['reset' => $reset]);
        }

        Session::flash('flash_message', 'This reset token does not exist or has expired.');

        return to_route('login::password::reset');
    }

    /**
     * Reset the password of the user.
     *
     * @throws Exception
     */
    public function resetPassword(Request $request): RedirectResponse
    {
        PasswordReset::query()->where('valid_to', '<', Carbon::now()->timestamp)->delete();
        $reset = PasswordReset::query()->where('token', $request->token)->first();
        if (! $reset) {
            Session::flash('flash_message', 'This reset token does not exist or has expired.');

            return to_route('login::password::reset');
        }

        $validated = $request->validate([
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $reset->user->setPassword($validated['password']);
        PasswordReset::query()->where('token', $request->token)->delete();
        Session::flash('flash_message', 'Your password has been changed.');

        return to_route('login::show');
    }

    /**
     * Show the page to synchronize passwords.
     */
    public function syncPasswordsIndex(): View
    {
        return view('auth.sync');
    }

    /**
     * Synchronize the password of the user.
     *
     * @throws Exception
     */
    public function syncPasswords(Request $request): View|RedirectResponse
    {
        $validated = $request->validate([
            'password' => ['required', 'current_password'],
        ]);
        $user = Auth::user();
        $user->setPassword($validated['password']);
        $this->syncGooglePassword($user, $validated['password']);

        return back();
    }

    /**
     * @throws \Google\Service\Exception
     * @throws \Google\Exception
     */
    private function syncGooglePassword(User $protoUser, string $password): void
    {
        $client = new Google_Client;
        $client->setAuthConfig(config('proto.google_application_credentials'));
        $client->useApplicationDefaultCredentials();
        $client->setSubject('superadmin@proto.utwente.nl');
        $client->setApplicationName('Proto Website');
        $client->setScopes(['https://www.googleapis.com/auth/admin.directory.user']);

        $directory = new Directory($client);
        $optParams = ['domain' => 'proto.utwente.nl', 'query' => "externalId:$protoUser->id"];
        $googleUser = $directory->users->listUsers($optParams)->getUsers();
        if ($googleUser == null) {
            return;
        }

        $directory->users->update(
            $googleUser[0]->id,
            new GoogleUser(['password' => $password])
        );
    }

    /**
     * Show the page to request a username via an email.
     */
    public function forgotUsernameIndex(): View
    {
        return view('auth.username');
    }

    /**
     * Send an email with the username to the user if found.
     */
    public function forgotUsername(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = User::whereEmail($request->get('email'))->first();
        $user?->sendForgotUsernameEmail();

        Session::flash('flash_message', 'If your e-mail belongs to an account, we have just e-mailed you the username.');

        return to_route('login::show');
    }

    /**
     * Show the page to gracefully change the password.
     */
    public function changePasswordIndex(): View
    {
        return view('auth.passchange');
    }

    /**
     * Change the password of the user.
     *
     * @throws Exception
     */
    public function changePassword(Request $request): View|RedirectResponse
    {
        $validated = $request->validate([
            'old_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = Auth::user();

        $user->setPassword($validated['password']);
        $this->syncGooglePassword($user, $validated['password']);
        Session::flash('flash_message', 'Your password has been changed.');

        return to_route('user::dashboard::show');
    }
}
