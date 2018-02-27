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

    @if(Event::getEventsForNewsletter()->count() > 0)

        @foreach(Event::getEventsForNewsletter() as $i => $event)

            <table style="margin: 0; padding: 0; border: none; background-color: {{ ($i % 2 == 0 ? '#f0f0f0' : '#fff') }};"
                   width="100%">

                <tr style="margin: 0; padding: 0; border: none;">

                    <td style="margin: 0; padding: 20px 40px; border: none;">

                        @if($event->image)
                            <img src="{{ $event->image->generateImagePath(350,100) }}" style="width: 100%;"/>
                        @endif

                        <p>
                            <strong>{{ $event->title }}</strong> @ {{ $event->location }}<br>
                            {{ date('l d F, H:i', $event->start) }}
                            - {{ ($event->end - $event->start >= 3600*24 ? date('l d F, H:i', $event->end) : date('H:i', $event->end)) }}
                        </p>

                        <p>

                            {!! Markdown::convertToHtml($event->summary) !!}

                        </p>

                        @if($event->activity && $event->activity->participants != 0)

                            <p>
                                <strong>Sign-up required!</strong><br>
                                @if($event->activity->participants > 0)
                                    <i>Places available:</i>
                                    {{ $event->activity->participants }}<br>
                                @elseif($event->activity->participants == -1)
                                    <i>Places available:</i>
                                    unlimited<br>
                                @endif
                                <i>Sign-up before:</i>
                                {{ date('l d F, H:i', $event->activity->registration_end) }}<br>
                                <i>Participation:</i>
                                {!! $event->activity->price > 0 ? '&euro;' . number_format($event->activity->price, 2) : 'Free!' !!}
                                <br>

                            </p>

                        @else

                            <p>
                                <i>No sign-up required.</i>
                            </p>

                        @endif

                        <p>
                            <a style="color: #000;" href="{{ route('event::show', ['id' => $event->getPublicId()]) }}">
                                Learn more! >>
                            </a>
                        </p>

                        @if($event->is_external)

                            <p>
                                <i><sub>This activity is not organized by S.A. Proto.</sub></i>
                            </p>

                        @endif

                    </td>

                </tr>

            </table>

        @endforeach

    @else

        <p>
            <strong>
                There are no activities to show. The newsletter will not be sent this week.
            </strong>
            If for some reason you're seeing this in your e-mail and not in your browser, something has gone horribly
            wrong. Please do let the board know this happened.
        </p>

    @endif

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
            stop receiving this e-mail, please click <a
                    href="{{ route('unsubscribefromlist', ['hash' => EmailList::generateUnsubscribeHash($user->id, $list->id)]) }}">here</a>.
        </sub>
    </p>

@endsection