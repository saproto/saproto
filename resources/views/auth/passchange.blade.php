@extends('auth.template')

@section('page-title')
    Change Password
@endsection

@section('login-body')
    <form method="POST" action="{{ route('login::password::change') }}">
        @csrf
        <p>
            <input
                id="old_password"
                type="password"
                name="old_password"
                class="form-control"
                placeholder="Old password"
            />
        </p>

        <p>
            <a
                class="btn btn-default btn-block"
                href="{{ route('login::password::reset') }}"
            >
                Forgot your password?
            </a>
        </p>

        <hr />

        <div class="text-start">
            Your new password needs to fullfill the following requirements:
            <ul>
                <li>
                    It needs to be at least
                    <b>10</b>
                    characters long
                </li>
                <li>
                    It needs to contain at least one
                    <b>uppercase</b>
                    letter
                </li>
                <li>
                    It needs to contain at least one
                    <b>lowercase</b>
                    letter
                </li>
                <li>
                    It needs to contain at least one
                    <b>number</b>
                </li>
                <li>
                    It needs to contain at least one
                    <b>special character</b>
                </li>
            </ul>
        </div>

        <p>
            <input
                id="password"
                type="password"
                name="password"
                class="form-control"
                minlength="10"
                placeholder="New password (at least 10 characters)"
            />
        </p>

        <p>
            <input
                id="password_confirmation"
                type="password"
                name="password_confirmation"
                class="form-control"
                minlength="10"
                placeholder="New password (again)"
            />
        </p>

        <p>
            <button type="submit" class="btn btn-success btn-block">
                Change password for {{ Auth::user()->calling_name }}
            </button>
        </p>

        <p>- or -</p>

        <p>
            <a
                href="https://tap.utwente.nl/tap/"
                class="btn btn-default btn-block"
                target="_blank"
            >
                Change your UTwente password
            </a>
        </p>
    </form>
@endsection
