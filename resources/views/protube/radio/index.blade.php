@extends('website.layouts.default')

@section('page-title')
    ProTube Radio Station Admin
@endsection

@section('content')

    <table class="table">

        <thead>

        <tr>

            <th>#</th>
            <th>Name</th>
            <th>Stream URL</th>
            <th>Controls</th>

        </tr>

        </thead>

        <tbody>

        @if (count($stations) > 0)

            @foreach($stations as $station)

                <tr>

                    <td>{{ $station->id }}</td>
                    <td>{{ $station->name }}</td>
                    <td>{{ $station->url }}</td>
                    <td>
                        <a class="btn btn-danger"
                           onclick="return confirm('Are you sure you want to delete {{ $station->name }}?');"
                           href="{{ route('protube::radio::delete', ['id' => $station->id]) }}" role="button">
                            <i class="fa fa-trash-o"></i> Delete
                        </a>
                        <a class="btn btn-success radio__test" data-url="{{ $station->url }}">
                            <i class="fa fa-volume-up"></i> Test
                        </a>
                    </td>

                </tr>

            @endforeach

        @endif

        <form method="post" action="{{ route('protube::radio::store') }}">

            {!! csrf_field() !!}

            <tr>

                <td></td>
                <td>
                    <input class="form-control" type="text" name="name" placeholder="Stream name">
                </td>
                <td>
                    <input class="form-control" type="text" name="url" placeholder="Stream URL">
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

@section('javascript')

    @parent

    <script type="text/javascript">

        var radio = document.createElement("AUDIO");

        $("body").delegate('.radio__test', 'click', function () {
            stopPlaying();
            radio.src = $(this).attr('data-url');
            radio.play();
            $(this).removeClass('btn-success radio__test').addClass('btn-info radio__stop').html('<i class="fa fa-volume-off"></i> Stop')
        });

        $("body").delegate('.radio__stop', 'click', function () {
            stopPlaying();
        });

        function stopPlaying() {
            $('.radio__stop').removeClass('btn-info radio__stop').addClass('btn-success radio__test').html('<i class="fa fa-volume-up"></i> Test')
            radio.src = "";
        }

    </script>

@endsection