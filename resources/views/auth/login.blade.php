@extends('website.layouts.panel')

@section('page-title')
    Authentication
@endsection

@section('panel-title')
    Authentication
@endsection

@section('panel-body')

    <form method="POST" action="{{ route('login::post') }}">

        {!! csrf_field() !!}

        <div class="form-group">
            <label for="recipient-name" class="control-label">Username:</label>
            <input type="text" class="form-control" id="username" name="email">
        </div>
        <div class="form-group">
            <label for="message-text" class="control-label">Password:</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>

        <div class="checkbox">
            <label>
                <input type="checkbox" id="remember" name="remember"> Remember me
            </label>
        </div>

        <hr>

        <p>
            To log-in to your Proto account, you can use the e-mail address registered to your account in combination
            with your password. If you are a Proto member, you also have a Proto username you can use instead of your
            e-mail address to save typing.
        </p>

        <p>
            If you previously linked them to your Proto account, you can use your University of Twente credentials as an
            alternative means to sign in.
        </p>

        @endsection

        @section('panel-footer')
            <button type="submit" class="btn btn-success">LOG-IN</button>

            <a class="btn btn-default pull-right" href="{{ route('login::resetpass') }}">Forgot your password?</a>

    </form>
@endsection