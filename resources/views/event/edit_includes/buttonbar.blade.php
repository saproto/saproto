<div class="card-footer border-bottom">

    <button type="submit" class="btn btn-success pull-right" style="margin-left: 15px;">Submit
    </button>

    @if($event)
        <a href="{{ route("event::delete", ['id' => $event->id]) }}"
           class="btn btn-danger pull-left">Delete</a>
    @endif

    <a href="{{ $event ? route('event::show', ['id' => $event->getPublicId()]) : URL::previous() }}"
       class="btn btn-default pull-right">Back to event</a>

</div>