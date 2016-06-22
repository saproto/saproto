@extends('emails.template')

@section('body')

    <p>
        Dear {{ $user->name }},
    </p>

    <p>
        You receive this e-mail because you, or somebody else, used this e-mail address while signing up for an account
        on the website of <a href="{{ route('homepage') }}">Study Association Proto</a>. If this wasn't you, please
        reply to this e-mail and we'll sort everything out.
    </p>

    <p>
        If it was you who registered an account, you can login to the website using the password below. Although the
        password is randomly generated, we advise you to change it to something else as soon as you log-in.
    </p>

    <p>
        <strong>{{ $password }}</strong>
    </p>

    <p>
        Should this e-mail raise any question, please don't hestitate to get in touch.
    </p>

    <p>
        Kind regards,
        <br>
        The board of Study Association Proto
    </p>

@endsection