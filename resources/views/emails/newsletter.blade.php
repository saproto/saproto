@extends('emails.template')

@section('body')

    <p>
        Hey {{ $user->calling_name }},
    </p>

    <p>
        Via this e-mail I would like to inform you about the upcoming activities of S.A. Proto. In this e-mail you will
        find a summary of the activities along with the most important info. If you want to know more, be sure to click
        through to our website!
    </p>

    <p>
        &nbsp;
    </p>

    @foreach($events as $i => $event)

        <table style="margin: 0; padding: 0; border: none; background-color: {{ ($i % 2 == 0 ? '#f0f0f0' : '#fff') }};" width="100%">

            <tr style="margin: 0; padding: 0; border: none;">

                <td style="margin: 0; padding: 20px 40px; border: none;">

                    <p>
                        <strong>{{ $event->title }}</strong> @ {{ $event->location }}<br>
                        {{ date('l d F, H:i', $event->start) }}
                        - {{ ($event->end - $event->start >= 3600*24 ? date('l d F, H:i', $event->end) : date('H:i', $event->end)) }}
                    </p>

                    <p>

                        {!! Markdown::convertToHtml($event->summary) !!}

                    </p>

                    @if($event->activity)

                        <p>
                            <strong>Sign-up required!</strong><br>
                            <i>Places available:</i>
                            {{ $event->activity->participants }}<br>
                            <i>Sign-up before:</i>
                            {{ date('l d F, H:i', $event->activity->registration_end) }}<br>
                            <i>Participation:</i>
                            {!! $event->activity->price > 0 ? '&euro;' . number_format($event->activity->price, 2) : 'Free!' !!}
                            <br>

                        </p>

                    @endif

                    <p>
                        <a style="color: #000;" href="{{ route('event::show', ['id' => $event->id]) }}">
                            Learn more! >>
                        </a>
                    </p>

                </td>

            </tr>

        </table>

    @endforeach

    <p>
        &nbsp;
    </p>

    <p>
        If anything about the activities is not clear, please let me know!
    </p>

    <p>
        Kind regards,<br>
        {{ config('proto.internal') }}
    </p>

    <p>
        &nbsp;
    </p>

    <p>
        ---
    </p>

    <p>
        <sub>
            You receive this e-mail because you subscribed to the weekly newsletter of S.A. Proto. If you would like to
            stop receiving this e-mail, please click <a href="{{ route('unsubscribefromlist', ['hash' => EmailList::generateUnsubscribeHash($user->id, $list->id)]) }}">here</a>.
        </sub>
    </p>

@endsection