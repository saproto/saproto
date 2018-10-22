<div class="card mb-3">

    <div class="card-header bg-dark text-white">
        Two-factor authentication
    </div>

    <div class="card-body">

        <a id="2fa"></a>

        @if($user->tfa_totp_key)

            <p class="card-text text-center">
                You have two-factor authentication enabled.
            </p>

        @else

            <p class="card-text">
                Two-factor authentication adds a second authentication factor, other then your password, to your
                account. This makes your account more secure against people guessing your password or using your
                computer with a password manager open. You will need to use this second authentication factor
                whenever you sign in to the website.
            </p>

            <p class="card-text">
                You can use any two-factor authentication app with Proto. Good recommendations are Google
                Authenticator or Authy. Look for them in your device's app store.
            </p>

        @endif

    </div>

    <div class="card-footer">

        @if($user->tfa_totp_key)

            <a href="{{ route('user::2fa::deletetimebased') }}"
               class="btn btn-outline-danger btn-block" onclick="return confirm('Do really want to unset time-based 2FA?')">
                Disable two-factor authentication
            </a>

        @else


            <a data-toggle="modal" data-target="#totp-modal" class="btn btn-outline-primary btn-block">
                Configure Two-Factor Authentication
            </a>

            @include('users.2fa.timebased')

        @endif

    </div>

</div>