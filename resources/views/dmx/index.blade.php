@extends('website.layouts.default')

@section('page-title')
    DMX Fixtures
@endsection

@section('content')

    @if (count($fixtures) > 0)

        <table class="table">

            <thead>

            <tr>

                <th>#</th>
                <th>Name</th>
                <th>First channel</th>
                <th>Last channel</th>
                <th></th>

            </tr>

            </thead>

            @foreach($fixtures as $fixture)

                <tr>

                    <td>{{ $fixture->id }}</td>
                    <td>{{ $fixture->name }}</td>
                    <td>{{ $fixture->channel_start }}</td>
                    <td>{{ $fixture->channel_end }}</td>
                    <td>
                        <a class="btn btn-xs btn-default"
                           href="{{ route('dmx::edit', ['id' => $fixture->id]) }}" role="button">
                            <i class="fa fa-pencil" aria-hidden="true"></i>
                        </a>
                        <a class="btn btn-xs btn-danger"
                           href="{{ route('dmx::delete', ['id' => $fixture->id]) }}" role="button">
                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                        </a>
                    </td>

                </tr>

                @foreach($fixture->getChannelNames() as $channel_id => $channel_name)
                    <tr>

                        <td></td>
                        <td><strong>{{ $channel_id }} => </strong>{{ $channel_name }}</td>
                        <td colspan="3"></td>

                    </tr>
                @endforeach

            @endforeach

        </table>

        <p style="text-align: center;">
            <a href="{{ route('dmx::add') }}">Create a new fixture.</a>
        </p>

    @else

        <p style="text-align: center;">
            There are no configure DMX fixtures.
            <a href="{{ route('dmx::add') }}">Create a new fixture.</a>
        </p>

    @endif

@endsection