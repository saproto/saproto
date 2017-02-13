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
                You receive this e-mail because you are subscribed to one or more of the following e-mail lists:
                @foreach($destination as $i => $list)
                    {{ $list['name'] }}
                    (<a href="{{ route('unsubscribefromlist', ['hash' => EmailList::generateUnsubscribeHash($user_id, $list['id'])]) }}">unsubscribe</a>){{ ($i + 1 == count($destination) ? '' : ', ') }}
                @endforeach
            @elseif($destination == 'users')
                This is a mandatory e-mail directed to all user accounts on the S.A. Proto website.
            @elseif($destination == 'members')
                This is a mandatory e-mail directed to all members off the S.A. Proto website.
            @endif
        </sub>
    </p>

@endsection