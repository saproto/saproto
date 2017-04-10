@extends('auth.template')

@section('page-title')
    Two Factor Authentication
@endsection

@section('login-body')

    <form method="POST" action="{{ route('login::post') }}">

        {!! csrf_field() !!}

        @if(Request::session()->get('2fa_user')->tfa_totp_key)

            <div class="form-group">
                <input type="text" class="form-control" id="code" name="2fa_totp_token"
                       placeholder="Time Based Auth Token">
            </div>

        @endif

        @if(Request::session()->get('2fa_user')->tfa_yubikey_identity)

            <div class="form-group">
                <input type="text" class="form-control" id="code" name="2fa_yubikey_token"
                       placeholder="YubiKey One Time Password" autofocus>
            </div>

        @endif

        <button type="submit" class="btn btn-default" style="width: 100%;">Submit</button>

    </form>
@endsection