<div class="panel panel-default">
    <div class="panel-heading">
        <strong>Two factor authentication</strong>
    </div>
    <div class="panel-body">

        <div class="row">

            <div class="col-md-6">

                @if($user->tfa_totp_key)

                    <div class="btn-group btn-group-justified" role="group">
                        <div class="btn-group" role="group">
                            <a href="{{ route('user::2fa::deletetimebased', ['user' => $user->id]) }}"
                               class="btn btn-danger">
                                Disable Time-Based 2FA
                            </a>
                        </div>
                    </div>

                @else

                    <div class="btn-group btn-group-justified" role="group">
                        <div class="btn-group" role="group">
                            <a data-toggle="modal" data-target="#totp-modal" class="btn btn-success">
                                Configure Time-Based 2FA
                            </a>
                        </div>
                    </div>

                    @include('users.2fa.timebased')

                @endif

            </div>

            <div class="col-md-6">

                @if($user->tfa_yubikey_identity)

                    <div class="btn-group btn-group-justified" role="group">
                        <div class="btn-group" role="group">
                            <a href="{{ route('user::2fa::deleteyubikey', ['user' => $user->id]) }}"
                               class="btn btn-danger">
                                Disable YubiKey 2FA
                            </a>
                        </div>
                    </div>

                @else

                    <div class="btn-group btn-group-justified" role="group">
                        <div class="btn-group" role="group">
                            <a data-toggle="modal" data-target="#yubikey-modal" class="btn btn-success">
                                Configure YubiKey 2FA
                            </a>
                        </div>
                    </div>

                    @include('users.2fa.yubikey')

                @endif

            </div>

        </div>

    </div>

</div>