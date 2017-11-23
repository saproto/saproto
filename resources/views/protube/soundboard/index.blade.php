@extends('website.layouts.default')

@section('page-title')
    ProTube Soundboard Admin
@endsection

@section('content')

    <table class="table">

        <thead>

        <tr>

            <th>#</th>
            <th>Name</th>
            <th>Controls</th>

        </tr>

        </thead>

        <tbody>

        @if (count($sounds) > 0)

            @foreach($sounds as $sound)

                    <tr>

                        <td>{{ $sound->id }}</td>
                        <td>
                            {{ $sound->name }}
                        </td>
                        <td>
                            <a class="btn btn-danger"
                               onclick="return confirm('Are you sure you want to delete {{ $sound->name }}?');"
                               href="{{ route('protube::soundboard::delete', ['id' => $sound->id]) }}" role="button">
                                <i class="fa fa-trash-o"></i> Delete
                            </a>
                            <a class="btn btn-success sound__test" data-url="{{ $sound->file->generatePath() }}">
                                <i class="fa fa-volume-up"></i> Test
                            </a>
                        </td>

                    </tr>

            @endforeach

        @endif

        <form method="post" action="{{ route('protube::soundboard::store') }}" enctype="multipart/form-data">

            {!! csrf_field() !!}

            <tr>

                <td></td>
                <td>
                    <div class="row">
                        <div class="col-md-8">
                            <input class="form-control" type="text" name="name" placeholder="Sound name">
                        </div>
                        <div class="col-md-4">
                            <input class="form-control" type="file" name="sound" id="sound">
                        </div>
                    </div>
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

        var sound = document.createElement("AUDIO");

        $("body").delegate('.sound__test', 'click', function () {
            sound.src = $(this).attr('data-url');
            sound.play();
        });

    </script>

@endsection
