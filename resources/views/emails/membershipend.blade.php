@extends('emails.template')

@section('body')

    <p>
        Dear {{ $user->name }},
    </p>

    <p>
        I'm writing to let you know we have officially terminated your membership at Study Association Proto. Any
        remaining purchases will be settled using the last withdrawal authorization on file. We also removed the
        information on your gender, nationality, birthdate and phone number from your user profile. Should wish to add
        these again, please visit your dashboard.

    <p>
        Your user account on the website will remain active. If you wish to delete your account or any data associated
        with your account, please head over to the dashboard.
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
        {{ config('proto.secretary') }}<br>
        <i>On behalf of the board of Study Association Proto</i>
    </p>

@endsection