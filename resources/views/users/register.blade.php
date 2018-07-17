@extends('website.layouts.panel')

@section('page-title')
    New Account Registration
@endsection

@section('panel-title')
    Registering a new account
@endsection

@section('panel-body')

    <form method="POST" action="{{ route('login::register') }}">

        @if(Session::get('wizard'))
            @include('users.registerwizard_macro')
        @endif

        <a href="{{ route('login::edu') }}" class="btn btn-success" style="width: 100%;">
            Create an account with your university account
        </a>

        <hr>

        @if(!Session::get('wizard'))

            <p>
                Using this form you can register a new account on the S.A. Proto website.
            </p>

            <p style="font-weight: bold;">
                Creating and having an account on the website does not make you a member of S.A. Proto and is free of
                charge.
            </p>

            <hr>

        @endif

        {!! csrf_field() !!}

        <div class="form-group">
            <label for="email" class="control-label">Your e-mail address:</label>
            <input type="text" class="form-control" id="email" name="email" placeholder="j.doe@student.utwente.nl"
                   value="{{ (Session::has('register_persist') ? Session::get('register_persist')['email'] : '') }}"
                   required>
            <p class="help-block">
                Your e-mail address will also be your username. Please enter a valid e-mail address as your password
                will be sent to this e-mail address.
            </p>
        </div>

        <hr>

        <div class="form-group">
            <div class="row">
                <div class="col-md-5">
                    <label for="name" class="control-label">Your first and last name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="John Doe"
                           value="{{ (Session::has('register_persist') ? Session::get('register_persist')['name'] : '') }}"
                           required>
                </div>
                <div class="col-md-5">
                    <label for="calling_name" class="control-label">Calling name</label>
                    <input type="text" class="form-control" id="calling_name" name="calling_name" placeholder="Johnny"
                           value="{{ (Session::has('register_persist') ? Session::get('register_persist')['calling_name'] : '') }}"
                           required>
                </div>
            </div>
        </div>

        <hr>

        <div class="checkbox">
            <label>
                <input type="checkbox" name="privacy_policy_acceptance" required>
                I have read and agree with the <a href="https://wiki.proto.utwente.nl/ict/privacy/start?do=export_pdf"
                                                  target="_blank">privacy policy</a> of S.A. Proto.
            </label>
        </div>

        <hr>

        {!! Recaptcha::render() !!}

        @endsection

        @section('panel-footer')
            <button type="submit" class="btn btn-success pull-right">Create my account</button>

    </form>
@endsection