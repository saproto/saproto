@extends('website.layouts.panel')

@section('page-title')
    Enabling Two Factor Authentication
@endsection

@section('panel-title')
    Configuring timed-based 2 Factor Authentication for {{ $user->name }}
@endsection

@section('panel-body')

    <form method="post" action="{{ route('user::2fa::addtimebased', ['user_id' => $user->id]) }}"
          class="form-horizontal">

        <div class="row">

            <p style="text-align: center;">
                Scan the code below with your favorite 2FA app and enter your code below to verify.
            </p>

            <div class="col-md-8 col-md-offset-2 col-xs-12 col-xs-offset-0">

                {!! csrf_field() !!}

                <p style="text-align: center;">
                    <img src="{{ $qrcode }}">
                </p>

                <p style="text-align: center;">
                    <input class="form-control" name="2facode" placeholder="Your six digit code.">
                </p>

                <p style="text-align: center;">
                    You can also enter the below secret key manually.<br>
                    <strong>{{ $secret }}</strong>
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