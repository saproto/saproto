@if ($upcomingEvents->count() > 0)
    <div class="card mb-3">
        <div class="card-header bg-dark text-white">Upcoming events</div>

        <div class="card-body">
            <div class="row">
                @foreach ($upcomingEvents as $event)
                    <div class="col-6">
                        @include(
                            'event.display_includes.event_block',
                            [
                                'event' => $event,
                            ]
                        )
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endif

@if ($pastEvents->count() > 0)
    <div class="card mb-3">
        <div class="card-header bg-dark text-white">Previously organised</div>

        <div class="card-body">
            <div class="row">
                @foreach ($pastEvents as $event)
                    <div class="col-6">
                        @include(
                            'event.display_includes.event_block',
                            [
                                'event' => $event,
                                'include_year' => true,
                            ]
                        )
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endif

@if ($pastHelpedEvents->count() > 0)
    <div class="card mb-3">
        <div class="card-header bg-dark text-white">
            Events previously helped at
        </div>

        <div class="card-body">
            <div class="row">
                @foreach ($pastHelpedEvents as $key => $event)
                    <div class="col-6">
                        @include(
                            'event.display_includes.event_block',
                            [
                                'event' => $event,
                                'include_year' => true,
                            ]
                        )
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endif
