@extends('auth.template')

@section('page-title')
    Proto Password Reset
@endsection

@section('login-body')

    <form method="POST" action="{{ route("login::resetpass::send") }}">

        {!! csrf_field() !!}

        <p>
            Please enter your e-mail address.
        </p>

        <div class="form-group">
            <input id="email" type="email" name="email" class="form-control" value="{{ old('email') }}"
                   placeholder="garrus.vakarian@example.com">
        </div>

        <p>
            <button type="submit" class="btn btn-success" style="width: 100%;">
                Send Password Reset Link
            </button>
        </p>

        <hr>

        <p>
            <a class="btn btn-default" href="https://utpm.utwente.nl/pmuser" target="_blank"
               style="width: 100%;">
                Reset UTwente Password
            </a>
        </p>

    </form>

@endsection