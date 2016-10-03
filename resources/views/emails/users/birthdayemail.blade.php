@extends('emails.template')

@section('body')

    <p>
        Hey {{ $user->calling_name }},
    </p>

    <p>
        I am writing you to congratulate you with
        your {{ (new NumberFormatter('en_US', NumberFormatter::ORDINAL))->format($user->age()) }} birthday! If you are
        able to drop by the Protopolis today I would love to congratulate you in person and offer you a free and
        complimentary birthday cookie. Have a great day!
    </p>

    <p>
        Kind regards,
        {{ config('proto.internal') }}
    </p>

@endsection