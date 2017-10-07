@extends('auth.template')

@section('page-title')
    Password Reset
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

        <p>
            <input id="password" type="password" name="password" class="form-control" minlength="10"
                   placeholder="New password (at least 10 characters)">
        </p>

        <p>
            <input id="password2" type="password" name="password_confirmation" class="form-control" minlength="10"
                   placeholder="New password (again)">
        </p>

        <p>
            <button type="submit" class="btn btn-success" style="width: 100%;">
                Reset password for {{ $reset->user->calling_name }}
            </button>
        </p>

    </form>

@endsection