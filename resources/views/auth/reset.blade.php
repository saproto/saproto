@extends('website.layouts.panel')

@section('page-title')
    Password Reset
@endsection

@section('panel-title')
    Password reset for {{ $reset->user->name }}
@endsection

@section('panel-body')

    <form method="POST" action="{{ route("login::resetpass::submit") }}" class="form-horizontal">

        {!! csrf_field() !!}

        <input type="hidden" name="token" value="{{ $reset->token }}">

        <div class="form-group">
            <label for="password" class="col-sm-3 control-label">New password</label>
            <div class="col-sm-9">
                <input id="password" type="password" name="password" class="form-control" minlength="8">
            </div>
        </div>

        <div class="form-group">
            <label for="password2" class="col-sm-3 control-label"></label>
            <div class="col-sm-9">
                <input id="password2" type="password" name="password_confirmation" class="form-control" minlength="8">
            </div>
        </div>

        @endsection

        @section('panel-footer')

            <button type="submit" class="btn btn-success pull-right">
                Reset Password
            </button>

    </form>

@endsection