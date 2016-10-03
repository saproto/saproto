@extends('emails.template')

@section('body')

    <p>
        Hey {{ $user->calling_name }},
    </p>

    <p>
        You receive this e-mail because you are needed! The organization of <i>{{ $help->activity->event->title }}</i>
        indicated they need <strong>{{ $help->amount }}</strong> people from the {{ $help->committee->name }} (of which
        you are a member) to help them out during the activity. If you feel inclined to help, please check the
        <a href="{{ route('event::show', ['id' => $help->activity->event->id]) }}">activity page</a> for more
        information and to indicate whether you want to help.
    </p>

    <p>
        Kind regards,
        <br>
        The board of Study Association Proto
    </p>

@endsection