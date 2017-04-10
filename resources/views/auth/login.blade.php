@extends('auth.template')

@section('page-title')
    Authentication
@endsection

@section('login-body')

    <form method="POST" action="{{ route('login::post') }}">

        {!! csrf_field() !!}

        <div class="form-group">
            <input type="text" class="form-control" id="username" name="email" placeholder="Username">
        </div>
        <div class="form-group">
            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
        </div>

        <p>
            <button type="submit" class="btn btn-success" style="width: 100%;">
                LOG-IN
            </button>
        </p>

        <div class="checkbox">
            <label>
                <input type="checkbox" id="remember" name="remember"> Remember me
            </label>
        </div>

        <br>

        <p>
            <a class="btn btn-default" href="{{ route('login::resetpass') }}" style="width: 100%;">
                Forgot your Proto password?
            </a>
        </p>

        <br>

        <hr>

        <br>

        <a href="{{ route('login::utwente') }}" class="btn btn-default" style="width: 100%;">
            University of Twente Login
        </a>

    </form>
@endsection