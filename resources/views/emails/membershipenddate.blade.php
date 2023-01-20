@extends('emails.template')

@section('body')

<p>
    Dear {{ $user->name }},
</p>

<p>
    I am writing to you to let you know that the secretary has set an end date for your membership at S.A. Proto.
</p>
<p>
    Your membership will end at: <b>{{Carbon::createFromTimestamp($user->member->member_untill)->format('d-m-Y')}}.</b><br>
    This means you are a full member before this date, but will not be for the following academic year.
    If you think this was a mistake and would like your membership to continue please contact me before this date.
    When you're membership actually ends you will get a follow-up e-mail from me.
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