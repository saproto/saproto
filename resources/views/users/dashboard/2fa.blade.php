<div class="panel panel-default">
    <div class="panel-heading">
        <strong>Two factor authentication</strong>
        <a id="2fa"></a>
    </div>
    <div class="panel-body">

        <div class="row">

            <div class="col-md-12">

                @if($user->tfa_totp_key)

                    <p style="text-align: center;">
                        You have two-factor authentication enabled.
                    </p>

                @else

                    <p>
                        Two factor authentication adds a second authentication factor, other then your password, to your
                        account. This makes your account more secure against people guessing your password or using your
                        computer with a password manager open. You will need to use this second authentication factor
                        whenever you sign in to the website.
                    </p>

                    <p>
                        You can use any two-factor authentication app with Proto. Good recommendations are Google
                        Authenticator or Authy. Look for them in your device's app store.
                    </p>

                @endif

            </div>

        </div>

    </div>

    <div class="panel-footer">

        @if($user->tfa_totp_key)

            <div onclick="return confirm('Do really want to unset time-based 2FA?')"
                 class="btn-group btn-group-justified" role="group">
                <div class="btn-group" role="group">
                    <a href="{{ route('user::2fa::deletetimebased') }}"
                       class="btn btn-danger">
                        Disable Two-Factor Authentication
                    </a>
                </div>
            </div>

        @else

            <div class="btn-group btn-group-justified" role="group">
                <div class="btn-group" role="group">
                    <a data-toggle="modal" data-target="#totp-modal" class="btn btn-success">
                        Configure Two-Factor Authentication
                    </a>
                </div>
            </div>

            @include('users.2fa.timebased')

        @endif

    </div>

</div>