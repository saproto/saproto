@extends('emails.template')

@section('body')

    <p>
        Dear {{ $user->name }},
    </p>

    <p>
        I'm writing to let you know we have officially terminated your membership at Study Association Proto. Any
        remaining purchases will be settled using the last withdrawal authorization on file.
    </p>

    <p>
        We're sorry to see you go.
    </p>

    <p>
        I hope to have informed you well via this e-mail, but should you have any questions left you can always come by
        at the Protopolis or send me an e-mail.
    </p>

    <p>
        Kind regards,<br>
        {{ $secretary }}<br>
        <i>On behalf of the board of Study Association Proto</i>
    </p>

@endsection