@extends('emails.template')

@section('body')

    <p>
        Hey {{ $user->calling_name }},
    </p>

    <p>
        You receive this e-mail because you indicated to be able to help at the
        <i>{{ $help->activity->event->title }}</i> activity as part of the {{ $help->committee->name }}. The
        organization of the activity indicated that they do not require help from your committee anymore, so unless you
        also want to participate in the activity you don't have to keep your time free anymore. Thank you for sign-up as
        helper in the first place!
    </p>

    <p>
        Kind regards,
        <br>
        The board of Study Association Proto
    </p>

@endsection