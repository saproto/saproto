@extends('website.layouts.default')

@section('page-title')
    Edit Newsletter
@endsection

@section('content')

    @if (count($events) > 0)

        <table class="table">

            <thead>

            <tr>

                <th>#</th>
                <th>Event</th>
                <th>When</th>
                <th>&nbsp;</th>
                <th>Controls</th>

            </tr>

            </thead>

            @foreach($events as $event)

                <tr style="opacity: {{ ($event->include_in_newsletter ? '1' : '0.4') }};">

                    <td>{{ $event->id }}</td>
                    <td>{{ $event->title }}</td>
                    <td>{{ $event->generateTimespanText('l j F, H:i', 'H:i', '-') }}</td>
                    <td>
                        <i class="fa fa-{{ ($event->include_in_newsletter ? 'check' : 'times') }}" aria-hidden="true"></i>
                    </td>
                    <td>
                        <a href="{{ route('event::innewsletter::toggle', ['id' => $event->id]) }}">
                            Toggle
                        </a>
                    </td>

                </tr>

            @endforeach

        </table>

    @else

        <p style="text-align: center;">
            There are no upcoming events. Seriously. Go fix that {{ Auth::user()->calling_name }}.
        </p>

        <p class="large-emoji" style="text-align: center;">
            😱
        </p>

    @endif

@endsection