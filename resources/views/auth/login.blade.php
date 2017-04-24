@extends('auth.template')

@section('page-title')
    Authentication
@endsection

@section('login-body')

    <form method="POST" action="{{ route('login::post') }}">

        {!! csrf_field() !!}

        <p>
            <input type="text" class="form-control" id="username" name="email" placeholder="Proto Username or E-mail"
                   value="{{ (Session::has('login_username') ? Session::get('login_username') : '') }}">
        </p>
        <p>
            <input type="password" class="form-control" id="password" name="password" placeholder="Proto Password">
        </p>

        <p>
            <button type="submit" class="btn btn-success" style="width: 100%;">
                Login with Proto Account
            </button>
        </p>

        <p>
            <a class="btn btn-default" href="{{ route('login::requestusername') }}" style="width: 100%;">
                Forgot your Proto username?
            </a>
        </p>

        <p>
            <a class="btn btn-default" href="{{ route('login::resetpass') }}" style="width: 100%;">
                Forgot your Proto password?
            </a>
        </p>

        <p>
            <a class="btn btn-default" href="https://github.com/saproto/saproto/wiki/The-Proto-Account" target="_blank"
               style="width: 100%;">
                What is a Proto account?
            </a>
        </p>

        <hr>

        <p>
            <a href="{{ route('login::utwente') }}" class="btn btn-success" style="width: 100%;">
                Login with UTwente Account
            </a>
        </p>

    </form>
@endsection