@extends('website.layouts.default')

@section('page-title')
    DMX Overrides
@endsection

@section('content')

    @if (count($overrides) > 0)

        <table class="table">

            <thead>

            <tr>

                <th>#</th>
                <th>Fixtures</th>
                <th>Color</th>
                <th>When</th>
                <th></th>

            </tr>

            </thead>

            @foreach($overrides as $override)

                <tr style="{{ $override->active() ? '' : 'opacity: 0.5;' }}">

                    <td>{{ $override->id }}</td>
                    <td>
                        @foreach($override->getFixtures() as $fixture)
                            {{ $fixture->name }}<br>
                        @endforeach
                    </td>
                    <td>
                        <span style="color: red;">
                            <i class="fa fa-tint" aria-hidden="true"></i>
                            {{ $override->red() }}
                        </span>&nbsp;&nbsp;
                        <span style="color: green;">
                                <i class="fa fa-tint" aria-hidden="true"></i>
                            {{ $override->green() }}
                            </span>&nbsp;&nbsp;
                        <span style="color: blue;">
                                <i class="fa fa-tint" aria-hidden="true"></i>
                            {{ $override->blue() }}
                            </span>&nbsp;&nbsp;
                        <i class="fa fa-sun-o" aria-hidden="true"></i>
                        {{ $override->brightness() }}
                    </td>
                    <td>
                        Start: {{ date('l F j Y, H:i', $override->start) }}<br>
                        End: {{ date('l F j Y, H:i', $override->end) }}
                    </td>
                    <td>
                        <a class="btn btn-xs btn-default"
                           href="{{ route('dmx::override::edit', ['id' => $override->id]) }}" role="button">
                            <i class="fa fa-pencil" aria-hidden="true"></i>
                        </a>
                        <a class="btn btn-xs btn-danger"
                           href="{{ route('dmx::override::delete', ['id' => $override->id]) }}" role="button">
                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                        </a>
                    </td>

                </tr>
            @endforeach

        </table>

        <p style="text-align: center;">
            <a href="{{ route('dmx::override::add') }}">Create a new override.</a>
        </p>

    @else

        <p style="text-align: center;">
            There are no configured overrides.
            <a href="{{ route('dmx::override::add') }}">Create a new override.</a>
        </p>

    @endif

@endsection