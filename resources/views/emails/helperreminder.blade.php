@extends('emails.template')

@section('body')

    <p>
        You receive this notifications because you have subscribed to committee helper reminders. You can unsubscribe <a
                href="{{ route('committee::show', ['id' => $committee->getPublicId()]) }}">here</a>.
    </p>

    <p>
        The {{ $event->title }} is in three days. The {{ $committee->name }} is scheduled to help there
        with {{ $help->amount }} people, but only {{ $helping_count }} have subscribed.
    </p>

@endsection
