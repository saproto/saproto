<div class="card mb-3">
    <div class="card-header bg-dark text-white">Upcoming events</div>
    <div class="card-body">

        @foreach(Event::where('secret', false)->where('end', '>=', date('U'))->orderBy('start')->limit($n)->get() as $key => $event)

            @include('event.display_includes.event_block', ['event'=> $event])

            <?php $week = date('W', $event->start); ?>

        @endforeach

        <a href="{{ route("event::list") }}" class="btn btn-info btn-block">Go to the calendar</a>
    </div>
</div>