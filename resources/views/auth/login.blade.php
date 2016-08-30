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
            <input type="text" class="form-control" id="username" name="email" placeholder="E-mail address or UTwente username">
        </div>
        <div class="form-group">
            <label for="message-text" class="control-label">Password:</label>
            <input type="password" class="form-control" id="password" name="password"
                   placeholder="Proto password or UTwente password">
        </div>

        <div class="checkbox">
            <label>
                <input type="checkbox" id="remember" name="remember"> Remember me
            </label>
        </div>

        @endsection

        @section('panel-footer')
            <button type="submit" class="btn btn-success">LOG-IN</button>

            <a class="btn btn-default pull-right" href="{{ route('login::resetpass') }}">Forgot your password?</a>

    </form>
@endsection