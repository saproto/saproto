@extends('emails.template')

@section('body')
    <p>Hey!</p>

    <p>
        There are {{ $unclosed->count() }} activities that do not have been closed, even though they ended more than a month ago!
        <br />
        Make sure to close them
        <a href="{{ route('event::financial::list') }}">here.</a>
    </p>

    <p>
        It is about the following activities:

    @foreach ($unclosed as $activity)
        <table
            style="
                    margin: 0;
                    padding: 0;
                    border: none;
                    background-color: #f0f0f0;
                    width: 100%;
                "
        >
            <tr style="margin: 0; padding: 0; border: none">
                    <p>
                        {{ $activity->event->title }} (€{{ $activity->price }})
                    </p>
                <hr />
            </tr>
        </table>
        @endforeach

        <p>Kind regards, The Activity Close Clerk</p>
        @endsection
