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
                <th>Mode</th>
                <th>Name</th>
                <th>First channel</th>
                <th>Last channel</th>
                <th>Properties</th>
                <th></th>

            </tr>

            </thead>

            @foreach($fixtures as $fixture)

                <tr>

                    <td>{{ $fixture->id }}</td>
                    <td>
                        @if($fixture->follow_timetable)
                            <i class="fa fa-calendar" aria-hidden="true"></i>
                        @endif
                    </td>
                    <td>{{ $fixture->name }}</td>
                    <td>{{ $fixture->channel_start }}</td>
                    <td>{{ $fixture->channel_end }}</td>
                    <td>
                        @if(count($fixture->getChannels('red')) > 0)
                            <span style="color: red;">
                                <i class="fa fa-tint" aria-hidden="true"></i>
                                {{ implode(", ", $fixture->getChannels('red')->pluck('id')->toArray()) }}
                            </span>&nbsp;&nbsp;
                        @endif
                        @if(count($fixture->getChannels('green')) > 0)
                            <span style="color: green;">
                                <i class="fa fa-tint" aria-hidden="true"></i>
                                {{ implode(", ", $fixture->getChannels('green')->pluck('id')->toArray()) }}
                            </span>&nbsp;&nbsp;
                        @endif
                        @if(count($fixture->getChannels('blue')) > 0)
                            <span style="color: blue;">
                                <i class="fa fa-tint" aria-hidden="true"></i>
                                {{ implode(", ", $fixture->getChannels('blue')->pluck('id')->toArray()) }}
                            </span>&nbsp;&nbsp;
                        @endif
                        @if(count($fixture->getChannels('brightness')) > 0)
                            <i class="fa fa-sun-o" aria-hidden="true"></i>
                            {{ implode(", ", $fixture->getChannels('brightness')->pluck('id')->toArray()) }}
                        @endif
                    </td>
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
            @endforeach

        </table>

        <p style="text-align: center;">
            <a href="{{ route('dmx::add') }}">Create a new fixture.</a>
        </p>

    @else

        <p style="text-align: center;">
            There are no configured fixtures.
            <a href="{{ route('dmx::add') }}">Create a new fixture.</a>
        </p>

    @endif

@endsection