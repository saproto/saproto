@if($event)

    <a href="{{ route('event::copy', ['id' => $event->id]) }}" class="btn btn-default btn-warning float-end ms-2">
        Copy
    </a>

    <button type="submit" class="btn btn-success float-end ms-2">
        Update event details
    </button>

    @include('website.layouts.macros.confirm-modal', [
        'action' => route("event::delete", ['id' => $event->id]),
        'classes' => 'btn btn-danger float-end ms-2',
        'text' => 'Delete',
        'message' => 'Are you sure you want to delete this event?',
    ])

    <a href="{{ route('event::show', ['id' => $event->getPublicId()]) }}" class="btn btn-default float-end">
        Back to event
    </a>

@else
    <button type="submit" class="btn btn-success float-end ms-2">
        Create
    </button>

    <a href="{{ route('event::list') }}" class="btn btn-default float-end">
        Back to calendar
    </a>
@endif