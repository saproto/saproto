@extends('website.layouts.panel')

@section('page-title')
    Password Reset
@endsection

@section('panel-title')
    Password Reset
@endsection

@section('panel-body')

    <form method="POST" action="{{ route("login::resetpass::submit") }}" class="form-horizontal">

        {!! csrf_field() !!}

        <input type="hidden" name="token" value="{{ $token }}">

        <div class="form-group">
            <label for="email" class="col-sm-3 control-label">Email</label>
            <div class="col-sm-9">
                <input id="email" type="email" name="email" class="form-control" value="{{ old('email') }}">
            </div>
        </div>

        <div class="form-group">
            <label for="password" class="col-sm-3 control-label">Password</label>
            <div class="col-sm-9">
                <input id="password" type="password" name="password" class="form-control" value="correct horse battery staple">
            </div>
        </div>

        <div class="form-group">
            <label for="password2" class="col-sm-3 control-label"></label>
            <div class="col-sm-9">
                <input id="password2" type="password" name="password_confirmation" class="form-control" value="correct horse battery staple">
            </div>
        </div>

        @endsection

        @section('panel-footer')

            <button type="submit" class="btn btn-success pull-right">
                Reset Password
            </button>

    </form>

@endsection