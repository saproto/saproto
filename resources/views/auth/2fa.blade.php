@extends('website.layouts.panel')

@section('page-title')
    Two Factor Authentication
@endsection

@section('panel-title')
    Two Factor Authentication
@endsection

@section('panel-body')

    <form method="POST" action="{{ route('login::post') }}">

        {!! csrf_field() !!}

        <p>
            This account is protected by two factor authentication. Please provide a one-time password from one of your
            supported methods of two factor authentication below.
        </p>

        @if(Request::session()->get('2fa_user')->tfa_totp_key)

            <div class="form-group">
                <label for="code" class="control-label">Your TOTP token:</label>
                <input type="text" class="form-control" id="code" name="2fa_totp_token" placeholder="123456">
            </div>

        @endif

        @if(Request::session()->get('2fa_user')->tfa_yubikey_identity)

            <div class="form-group">
                <label for="code" class="control-label">Your YubiKey OTP:</label>
                <input type="password" class="form-control" id="code" name="2fa_yubikey_token"
                       placeholder="Re-insert YubiKey or press button" autofocus>
            </div>

        @endif

        @endsection

        @section('panel-footer')
            <button type="submit" class="btn btn-success">LOG-IN</button>

    </form>
@endsection