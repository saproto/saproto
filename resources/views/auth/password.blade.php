@extends('auth.template')

@section('page-title')
    Password Reset
@endsection

@section('login-body')

    <form method="POST" action="{{ route("login::resetpass::send") }}">

        {!! csrf_field() !!}

        <p>
            Please enter your e-mail address.
        </p>

        <div class="form-group">
            <input id="email" type="email" name="email" class="form-control" value="{{ old('email') }}"
                   placeholder="username@proto.utwente.nl">
        </div>

        <p>
            <button type="submit" class="btn btn-default" style="width: 100%;">
                Send Password Reset Link
            </button>
        </p>

    </form>

@endsection