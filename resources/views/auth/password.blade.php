@extends('website.layouts.panel')

@section('page-title')
    Password Reset
@endsection

@section('panel-title')
    Password Reset
@endsection

@section('panel-body')

    <form method="POST" action="{{ route("login::resetpass::send") }}" class="form-horizontal">

        {!! csrf_field() !!}

        <p>
            If you forgot the password to your <strong>Proto account</strong>, you can request a new password using this
            form. All you have to do is put in your e-mail address (and be sure to use the one associated with your
            account), hit the button and wait for our e-mail!
        </p>

        <p>
            If you have your University of Twente account linked to your Proto account, you can also log-in and set a
            new Proto password using those credentials.
        </p>

        <p>
            This form is NOT for resetting your UTwente password. If you're looking to do that, please click
            <a href="https://utpm.utwente.nl/" target="_blank">here</a>.
        </p>

        <hr>

        <div class="form-group">
            <label for="email" class="col-sm-2 control-label">Email</label>
            <div class="col-sm-10">
                <input id="email" type="email" name="email" class="form-control" value="{{ old('email') }}">
            </div>
        </div>

        @endsection

        @section('panel-footer')

            <button type="submit" class="btn btn-success pull-right">
                Send Password Reset Link
            </button>

    </form>

@endsection