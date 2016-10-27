@extends('website.layouts.default')

@section('page-title')
    Narrowcasting Admin
@endsection

@section('content')

    @if (count($messages) > 0)

        <table class="table">

            <thead>

            <tr>

                <th>#</th>
                <th></th>
                <th>Campaign name</th>
                <th>Start</th>
                <th>End</th>
                <th>Slide duration</th>
                <th>Controls</th>

            </tr>

            </thead>

            @foreach($messages as $message)

                <tr {!! ($message->campaign_end < date('U') ? 'style="opacity: 0.5;"': '') !!}>

                    <td>{{ $message->id }}</td>
                    <td>{!! $message->video() ? '<i class="fa fa-youtube-play" aria-hidden="true"></i>' : '<i class="fa fa-picture-o" aria-hidden="true"></i>' !!}</td>
                    <td>{{ $message->name }}</td>
                    <td>{{ date('l F j Y, H:i', $message->campaign_start) }}</td>
                    <td>{{ date('l F j Y, H:i', $message->campaign_end) }}</td>
                    <td>{{ $message->slide_duration }} seconds</td>
                    <td>
                        <a class="btn btn-xs btn-default"
                           href="{{ route('narrowcasting::edit', ['id' => $message->id]) }}" role="button">
                            <i class="fa fa-pencil" aria-hidden="true"></i>
                        </a>
                        <a class="btn btn-xs btn-danger"
                           href="{{ route('narrowcasting::delete', ['id' => $message->id]) }}" role="button">
                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                        </a>
                    </td>

                </tr>

            @endforeach

        </table>

        <p style="text-align: center;">
            <a href="{{ route('narrowcasting::add') }}">Create a new campaign</a> or <a
                    href="{{ route('narrowcasting::clear') }}">delete all past campaigns</a>.
        </p>

    @else

        <p style="text-align: center;">
            There are currently no campaigns to display.
            <a href="{{ route('narrowcasting::add') }}">Create a new campaign.</a>
        </p>

    @endif

@endsection