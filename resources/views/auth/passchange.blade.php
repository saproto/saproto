@extends('auth.template')

@section('page-title')
    Change Password
@endsection

@section('login-body')

    <form method="POST" action="{{ route("login::password::change") }}">

        {!! csrf_field() !!}

        <p>
            <input id="old_password" type="password" name="old_password" class="form-control"
                   placeholder="Old password">
        </p>

        <p>
            <a class="btn btn-default" href="{{ route('login::resetpass') }}" style="width: 100%;">
                Forgot your password?
            </a>
        </p>

        <hr>

        <p>
            <input id="new_password1" type="password" name="new_password1" class="form-control" minlength="10"
                   placeholder="New password (at least 10 characters)">
        </p>

        <p>
            <input id="new_password2" type="password" name="new_password2" class="form-control" minlength="10"
                   placeholder="New password (again)">
        </p>

        <p>
            <button type="submit" class="btn btn-success" style="width: 100%;">
                Change password for {{ Auth::user()->calling_name }}
            </button>
        </p>

        <p>
            - or -
        </p>

        <p>
            <a href="https://tap.utwente.nl/tap/" class="btn btn-default" style="width: 100%;" target="_blank">
                Change your UTwente password
            </a>
        </p>

    </form>

@endsection