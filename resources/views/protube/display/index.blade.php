@extends('website.layouts.default')

@section('page-title')
    ProTube Display Admin
@endsection

@section('content')

    <table class="table">

        <thead>

        <tr>

            <th>#</th>
            <th>Name</th>
            <th>Display URL</th>
            <th>Display Number</th>
            <th>Controls</th>

        </tr>

        </thead>

        <tbody>

        @if (count($stations) > 0)

            @foreach($stations as $station)

                <form method="post" action="{{route('protube::display::update', ['id'=>$station->id])}}">

                    {!! csrf_field() !!}

                    <tr>

                        <td>{{ $station->id }}</td>
                        <td>
                            <input class="form-control" type="text" name="name" value="{{ $station->name }}">
                        </td>
                        <td>
                            <input class="form-control" type="text" name="url" value="{{ $station->url }}">
                        </td>
                        <td>
                            <input class="form-control" type="text" name="display" value="{{ $station->display }}">
                        </td>
                        <td>
                            <a class="btn btn-danger"
                               onclick="return confirm('Are you sure you want to delete {{ $station->name }}?');"
                               href="{{ route('protube::display::delete', ['id' => $station->id]) }}" role="button">
                                <i class="fa fa-trash-o"></i> Delete
                            </a>
                            <button class="btn btn-success" type="submit"
                                    href="{{ route('protube::display::update', ['id' => $station->id]) }}"
                                    role="button">
                                <i class="fa fa-pencil"></i> Update
                            </button>
                        </td>

                    </tr>

                </form>

            @endforeach

        @endif

        <form method="post" action="{{ route('protube::radio::store') }}">

            {!! csrf_field() !!}

            <tr>

                <td></td>
                <td>
                    <input class="form-control" type="text" name="name" placeholder="Screen name">
                </td>
                <td>
                    <input class="form-control" type="text" name="url" placeholder="Screen URL">
                </td>
                <td>
                    <input class="form-control" type="text" name="display" placeholder="Screen #">
                </td>
                <td>
                    <button type="submit" class="btn btn-success" role="button">
                        <i class="fa fa-save" aria-hidden="true"></i> Save
                    </button>
                </td>

            </tr>

        </form>

        </tbody>

    </table>

@endsection