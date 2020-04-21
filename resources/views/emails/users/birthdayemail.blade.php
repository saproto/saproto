@extends('emails.template')

@section('body')

    <p>
        Hey {{ $user->calling_name }},
    </p>

    <p>
        We are writing you to congratulate you with your birthday! Because of the coronavirus, we cannot give you the
        customary birthday cookie in Protopolis or the birthday pull at a Proto Drink. However, if we are able to do a
        Proto Drink before the summer holidays, we would like to invite you to stop by and collect your free birthday
        drink (one beer or one soda). 😄 We hope you have a great day!
    </p>

    <img src="{{ asset('images/emails/birthday.jpg') }}" style="width: 100%;">

    <p>
        Kind regards,
        {{ config('proto.internal') }}
    </p>

@endsection
