@if(!$event->secret || (
Auth::check() && (($event->activity && $event->activity->isParticipating(Auth::user())) || Auth::user()->can('board'))
))

    <a class="card mb-3" style="text-decoration: none !important;"
       href="{{ route('event::show', ['id' => $event->getPublicId()]) }}">

        <div class="card-body" style="text-align: left;
                background: linear-gradient(rgba(255, 255, 255, 0.75),rgba(255, 255, 255, 0.75)), {{ $event->image ? sprintf('url(%s);', $event->image->generateImagePath(800,300)) : '#eee;' }};
                background-size: cover; background-position: center center;">

            @if($event->activity && Auth::check())
                @if($event->activity->isParticipating(Auth::user()))
                    <i class="fa fa-check green" aria-hidden="true" title="You participate in this activity."></i>
                @endif
                @if($event->activity->isHelping(Auth::user()))
                    <i class="fa fa-life-ring" style="color: red;" aria-hidden="true"
                       title="You are helping with this activity."></i>
                @endif
            @endif
            @if (Auth::user() && $event->hasBoughtTickets(Auth::user()))
                <i class="fa fa-ticket" style="color: dodgerblue;" aria-hidden="true"
                   title="You bought a ticket for this event."></i>
            @endif
            @if (Auth::check() && Auth::user()->member && $event->activity && $event->activity->inNeedOfHelp(Auth::user()))
                <i class="fa fa-exclamation-triangle" style="color: red;" aria-hidden="true"
                   title="This activity needs help, and you can provide that!"></i>
            @endif
            <strong>{{ $event->title }}</strong>

            <br>

            <i class="fa fa-map-marker" aria-hidden="true"></i> {{ $event->location }}

            <br>

            <i class="fa fa-clock-o" aria-hidden="true"></i>
            {{ $event->generateTimespanText('D j M, H:i', 'H:i', '-') }}

            @if($event->is_external)
                <br>

                <i class="fa fa-info-circle" aria-hidden="true"></i> Not Organized
                by S.A. Proto
            @endif

        </div>

    </a>

@endif