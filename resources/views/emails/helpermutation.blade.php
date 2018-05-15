@extends('emails.template')

@section('body')

    <p>
        You receive this notifications because you have subscribed to committee helper reminders. You can unsubscribe <a
                href="{{ route('committee::show', ['id' => $committee->getPublicId()]) }}">here</a>.
    </p>

    <p>
        <strong>{{ $helper_name }}</strong> just {{ $helping ? 'subscribed' : 'unsubscribed' }} to help
        the {{ $committee->name }} for the activity <a href="{{ route('event::show', ['id' => $event->getPublicId()]) }}">{{ $event->title }}</a>.
    </p>

@endsection
