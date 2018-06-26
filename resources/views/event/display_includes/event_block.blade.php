@if(!$event->secret || (
Auth::check() && (($event->activity && $event->activity->isParticipating(Auth::user())) || Auth::user()->can('board'))
))
    <a class="activity" href="{{ route('event::show', ['id' => $event->getPublicId()]) }}">

        <div class="activity" {!! ($event->secret ? 'style="opacity: 0.3;"' : '') !!}>

            <p class="ellipsis">
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
                @if ($event->activity && $event->activity->inNeedOfHelp(Auth::user()))
                    <i class="fa fa-exclamation-triangle" style="color: red;" aria-hidden="true"
                       title="This activity needs help, and you can provide that!"></i>
                @endif
                <strong>{{ $event->title }}</strong>
            </p>

            <p>
                <i class="fa fa-map-marker" aria-hidden="true"></i> {{ $event->location }}
            </p>

            <p>
                <i class="fa fa-clock-o" aria-hidden="true"></i>
                {{ $event->generateTimespanText('D j M, H:i', 'H:i', '-') }}
            </p>

            @if($event->is_external)
                <p>
                    <i class="fa fa-info-circle" aria-hidden="true"></i> Not Organized
                    by S.A. Proto
                </p>
            @endif

        </div>

    </a>
@endif