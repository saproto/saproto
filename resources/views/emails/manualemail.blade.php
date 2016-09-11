@extends('emails.template')

@section('body')

    {!! Markdown::convertToHtml($body) !!}

    <p>
        &nbsp;&nbsp;
    </p>

    <p>
        ---
    </p>

    <p>
        <sub>
            @if(is_array($destination))
                You receive this e-mail because you are subscribed to one or more of the following e-mail
                lists: <i>{{ implode(', ', $destination) }}</i>. If you would like to unsubscribe from any of these
                lists
                please visit your <a href="{{ route('user::dashboard') }}">dashboard</a> on the S.A. Proto website.
            @elseif($destination == 'users')
                This is a mandatory e-mail directed to all user accounts on the S.A. Proto website.
            @elseif($destination == 'members')
                This is a mandatory e-mail directed to all members off the S.A. Proto website.
            @endif
        </sub>
    </p>

@endsection