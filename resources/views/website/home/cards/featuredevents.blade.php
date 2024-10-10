@if(count($featuredEvents) > 0)

    <div class="card mb-3">
        <div class="card-header bg-dark text-white">
            <i class="fas fa-star fa-fw me-2"></i> Featured events
        </div>
        <div class="card-body">


            @foreach($featuredEvents as $key => $event)
                @php /** @var \App\Models\Event $event */ @endphp

                @include('event.display_includes.event_block', ['event'=> $event, 'countdown' => true])

                @php($week = $event->start->format('W'))

            @endforeach

        </div>
    </div>

@endif
