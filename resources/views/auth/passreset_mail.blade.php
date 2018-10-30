@extends('auth.template')

@section('page-title')
    Password Reset
@endsection

@section('login-body')

    <form method="POST" action="{{ route("login::resetpass::send") }}">

        {!! csrf_field() !!}

        <p>
            Please enter your e-mail address.
        </p>

        <p>
            <input id="email" type="email" name="email" class="form-control" value="{{ old('email') }}"
                   placeholder="garrus.vakarian@example.com">
        </p>

        <p>
            <button type="submit" class="btn btn-success" style="width: 100%;">
                Send password reset link
            </button>
        </p>

        <hr>

        <p>
            <a class="btn btn-outline-secondary " href="https://tap.utwente.nl/tap/pwman/index.php" target="_blank"
               style="width: 100%;">
                Reset UTwente password
            </a>
        </p>

    </form>

@endsection