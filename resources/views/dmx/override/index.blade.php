@extends('website.layouts.redesign.dashboard')

@section('page-title')
    DMX Overrides
@endsection

@section('container')

    <div class="row justify-content-center">

        <div class="col-md-8">

            <div class="card mb-3">

                <div class="card-header bg-dark text-white">
                    @yield('page-title')
                    <a href="{{ route('dmx::override::add') }}" class="badge badge-info float-right">
                        Create a new override.
                    </a>
                </div>

                @if (count($overrides) > 0)

                    <table class="table table-hover">

                        <thead>

                        <tr>

                            <th>Fixtures</th>
                            <th colspan="4">Color</th>
                            <th>When</th>
                            <th></th>

                        </tr>

                        </thead>

                        @foreach($overrides as $override)

                            <tr style="{{ $override->active() ? '' : 'opacity: 0.5;' }}">

                                <td>
                                    @foreach($override->getFixtures() as $fixture)
                                        {{ $fixture->name }}<br>
                                    @endforeach
                                </td>
                                <td>
                                    <span style="color: red;">
                                        <i class="fas fa-tint" aria-hidden="true"></i>
                                        {{ $override->red() }}
                                    </span>
                                </td>
                                <td>
                                    <span style="color: green;">
                                        <i class="fas fa-tint" aria-hidden="true"></i>
                                        {{ $override->green() }}
                                    </span>
                                </td>
                                <td>
                                    <span style="color: blue;">
                                        <i class="fas fa-tint" aria-hidden="true"></i>
                                        {{ $override->blue() }}
                                    </span>
                                </td>
                                <td>
                                    <i class="fas fa-sun" aria-hidden="true"></i>
                                    {{ $override->brightness() }}
                                </td>
                                <td>
                                    Start: {{ date('l F j Y, H:i', $override->start) }}<br>
                                    End: {{ date('l F j Y, H:i', $override->end) }}
                                </td>
                                <td>
                                    <a class="btn btn-xs btn-default mr-2"
                                       href="{{ route('dmx::override::edit', ['id' => $override->id]) }}">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a class="btn btn-xs btn-danger"
                                       href="{{ route('dmx::override::delete', ['id' => $override->id]) }}">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>

                            </tr>
                        @endforeach

                    </table>

                @else

                    <div class="card-body">
                        <p class="card-text text-center">
                            There are no configured overrides.
                        </p>
                    </div>

                @endif

            </div>

        </div>

    </div>

@endsection