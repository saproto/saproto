<div class="card-footer border-bottom">

    <button type="submit" class="btn btn-success float-right" style="margin-left: 15px;">Submit
    </button>

    @if($event)
        <a href="{{ route("event::delete", ['id' => $event->id]) }}"
           class="btn btn-danger">Delete</a>
    @endif

    <a href="{{ $event ? route('event::show', ['id' => $event->getPublicId()]) : URL::previous() }}"
       class="btn btn-default">Back to event</a>

</div>