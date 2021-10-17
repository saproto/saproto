@extends('emails.template')

@section('body')

    <p>
        Hi {{ $user->calling_name }},
    </p>

    <p>
        Happy birthday! As you might know, Proto has been opened for a while, so you can now come get your birthday cookie again! Just hop by the Protopolis and ask a board member for your birthday cookie and we will be glad to help you out.
    </p>

    <img alt="The board wishing you a happy birthday" src="{{ asset('images/emails/birthday.jpg') }}">

    <p>
        Have a great day,
        Board {{ settings()->group('board')->get('board_number') }}
    </p>

@endsection
