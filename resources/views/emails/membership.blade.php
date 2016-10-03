@extends('emails.template')

@section('body')

    <p>
        Dear {{ $user->calling_name }},
    </p>

    <p>
        Welcome as the newest member of Study Association Proto! My name is {{ $internal }} and I would like to give a
        little introduction to the association. The room where you probably just signed up in is our association room
        called the Protopolis. In this room we offer free coffee and tea and sell other foods and drinks via the
        OmNomCom. At the OmNomCom you can also register various RFID-enabled cards for fast checkout.
    </p>

    <p>
        As an association we also organise a lot of activities, these activities are very diverse and can be both fun
        and educative. You can sign up for these activities on our <a href='https://www.saproto.nl'>website</a>. We
        also have a <a href='https://www.facebook.com/groups/574894482542033/'>private Facebook group</a> where we keep
        you posted on things going around the Protopolis and upcoming activities. Finally, we also have membership
        passes. You can pick yours up at the Protopolis and use it to get discounts at various stores and food-chains.
    </p>

    <p>
        I hope to have informed you well via this e-mail, but should you have any questions left you can always come by
        at the Protopolis or send me an e-mail.
    </p>

    <p>
        Kind regards,<br>
        {{ $internal }}<br>
        <i>On behalf of the board of Study Association Proto</i>
    </p>

@endsection