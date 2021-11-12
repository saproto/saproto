<div class="card-footer border-bottom">

    <button type="submit" class="btn btn-success float-end ms-4">Submit
    </button>

    @if($event)
        <a href="{{ route("event::delete", ['id' => $event->id]) }}"
           class="btn btn-danger float-start">Delete</a>
    @endif

    <a href="{{ $event ? route('event::show', ['id' => $event->getPublicId()]) : URL::previous() }}"
       class="btn btn-default float-end">Back to event</a>

</div>