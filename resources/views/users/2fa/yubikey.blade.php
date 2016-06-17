@extends('website.layouts.panel')

@section('page-title')
    Enabling Two Factor Authentication
@endsection

@section('panel-title')
    Configuring YubiKey 2 Factor Authentication for {{ $user->name }}
@endsection

@section('panel-body')

    <form method="post" action="{{ route('user::2fa::addyubikey', ['user_id' => $user->id]) }}"
          class="form-horizontal">

        <div class="row">

            <p style="text-align: center;">
                Insert your YubiKey and, if necessary, press the button on it.
            </p>

            <div class="col-md-8 col-md-offset-2 col-xs-12 col-xs-offset-0">

                {!! csrf_field() !!}

                <p style="text-align: center;">
                    <input type="password" class="form-control" name="2facode" placeholder="Your YubiKey OTP." autofocus>
                </p>

            </div>

        </div>

        @endsection

        @section('panel-footer')

            <div class="pull-right">
                <input type="submit" class="btn btn-success" value="Save">
                <a onClick="javascript:history.go(-1);" class="btn btn-default">Cancel</a>
            </div>

    </form>

@endsection