@if(!$event->secret || (
Auth::check() && (($event->activity && $event->activity->isParticipating(Auth::user())) || Auth::user()->can('board'))
))

    <a class="card mb-3" style="text-decoration: none !important;"
       href="{{ route('event::show', ['id' => $event->getPublicId()]) }}">

        <div class="card-body" style="text-align: left;
                background: linear-gradient(rgba(255, 255, 255, 0.9),rgba(255, 255, 255, 0.9)), {{ $event->image && (!isset($hide_photo) || !$hide_photo) ? sprintf('url(%s);', $event->image->generateImagePath(800,300)) : '#eee;' }};
                background-size: cover; background-position: center center;">

            @if($event->secret)
                <span class="badge badge-info float-right"><i class="fas fa-eye-slash fa-fw mr-1"></i> Secret activity!</span>
            @endif

            @if($event->activity && Auth::check())
                @if($event->activity->isParticipating(Auth::user()))
                    <i class="fas fa-check text-primary fa-fw" aria-hidden="true"
                       title="You participate in this activity."></i>
                @endif
                @if($event->activity->isHelping(Auth::user()))
                    <i class="fas fa-life-ring fa-fw" style="color: red;" aria-hidden="true"
                       title="You are helping with this activity."></i>
                @endif
            @endif
            @if (Auth::user() && $event->hasBoughtTickets(Auth::user()))
                <i class="fas fa-ticket-alt fa-fw" style="color: dodgerblue;" aria-hidden="true"
                   title="You bought a ticket for this event."></i>
            @endif
            @if (Auth::check() && Auth::user()->member && $event->activity && $event->activity->inNeedOfHelp(Auth::user()))
                <i class="fas fa-exclamation-triangle fa-fw" style="color: red;" aria-hidden="true"
                   title="This activity needs help, and you can provide that!"></i>
            @endif
            <strong>{{ $event->title }}</strong>

            <br>

            <i class="fas fa-clock fa-fw" aria-hidden="true"></i>
            {{ $event->generateTimespanText('D j M, H:i', 'H:i', '-') }}

            <br>

            <i class="fas fa-map-marker-alt fa-fw" aria-hidden="true"></i> {{ $event->location }}

            @if($event->is_external)
                <br>

                <i class="fas fa-info-circle fa-fw" aria-hidden="true"></i> Not Organized
                by S.A. Proto
            @endif

        </div>

    </a>

@endif