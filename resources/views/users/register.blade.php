@extends('auth.template')

@section('page-title')
    Register account
@endsection

@section('login-body')

    <form method="POST" action="{{ route('login::register') }}" class="text-left">

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

        <p>
            <input type="text" class="form-control" id="email" name="email" placeholder="Your e-mail address" required
                   value="{{ (Session::has('register_persist') ? Session::get('register_persist')['email'] : '') }}">
        </p>

        <p>
            Your e-mail address will also be your username. Please enter a valid e-mail address as your password will be
            sent to this e-mail address.
        </p>

        <hr>

        <p>
            <input type="text" class="form-control" id="name" name="name" placeholder="Full name" required
                   value="{{ (Session::has('register_persist') ? Session::get('register_persist')['name'] : '') }}">
        </p>

        <p>
            <input type="text" class="form-control" id="calling_name" name="calling_name" placeholder="Calling name"
                   required
                   value="{{ (Session::has('register_persist') ? Session::get('register_persist')['calling_name'] : '') }}">
        </p>

        <hr>

        <p>
            <a a href="https://wiki.proto.utwente.nl/ict/privacy/start?do=export_pdf"
               target="_blank" class="btn btn-outline-secondary btn-block">
                Privacy policy
            </a>
        </p>

        <div class="checkbox">
            <label>
                <input type="checkbox" name="privacy_policy_acceptance" required>
                I have read and acknowledge the privacy policy.
            </label>
        </div>

        <hr>

        {!! Recaptcha::render() !!}

        <hr>

        <button type="submit" class="btn btn-success btn-block">Create my account</button>

    </form>

@endsection