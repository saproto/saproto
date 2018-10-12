@extends('auth.template')

@section('page-title')
    Authentication
@endsection

@section('login-body')

    <form method="POST" action="{{ route('login::post') }}">

        {!! csrf_field() !!}

        <p>
            <a href="{{ route('login::edu') }}" class="btn btn-success" style="width: 100%;">
                Login with university account
            </a>
        </p>

        <p>
            - or -
        </p>

        <p>
            <input type="text" class="form-control" id="username" name="email" placeholder="Username or E-mail"
                   value="{{ (Session::has('login_username') ? Session::get('login_username') : '') }}">
        </p>
        <p>
            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
        </p>

        <p>
            <button type="submit" class="btn btn-success" style="width: 100%;">
                Login with Proto account
            </button>
        </p>

        <p>
            <a class="btn btn-outline-secondary" href="{{ route('login::register') }}" style="width: 100%;">
                Create Proto account
            </a>
        </p>

        <p>
            <a class="btn btn-outline-secondary" href="{{ route('login::requestusername') }}" style="width: 100%;">
                Forgot your username?
            </a>
        </p>

        <p>
            <a class="btn btn-outline-secondary" href="{{ route('login::resetpass') }}" style="width: 100%;">
                Forgot your password?
            </a>
        </p>

    </form>
@endsection