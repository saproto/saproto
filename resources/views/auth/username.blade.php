@extends('auth.template')

@section('page-title')
    Request Proto Username
@endsection

@section('login-body')

    <form method="POST" action="{{ route("login::requestusername") }}">

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
                What is my Proto username?
            </button>
        </p>

    </form>

@endsection