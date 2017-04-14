@extends('auth.template')

@section('page-title')
    Proto Password Reset
@endsection

@section('login-body')

    <form method="POST" action="{{ route("login::resetpass::submit") }}">

        {!! csrf_field() !!}

        <input type="hidden" name="token" value="{{ $reset->token }}">

        <p>
            You're resetting the password for:
            <br>
            <strong>{{ $reset->user->name }}</strong>
        </p>

        <br>

        <div class="form-group">
            <input id="password" type="password" name="password" class="form-control" minlength="8"
                   placeholder="New password">
        </div>

        <div class="form-group">
            <input id="password2" type="password" name="password_confirmation" class="form-control" minlength="8"
                   placeholder="New password again">
        </div>

        <button type="submit" class="btn btn-default" style="width: 100%;">
            Reset Password for {{ $reset->user->calling_name }}
        </button>

    </form>

@endsection