@extends('website.layouts.default')

@section('page-title')
    Album Administration
@endsection

@section('content')

    @if (count($albums) > 0)

        <table class="table">

            <thead>

            <tr>

                <th>Title</th>
                <th>Members only</th>

            </tr>

            </thead>

            @foreach($albums as $album)

                <tr>

                    <td>{{ $album->name }}</td>
                    <td>
                        <a class="btn btn-xs btn-default"
                           href="{{ route('photo::toggleprivate', ['id' => $album->id]) }}" role="button">
                            @if ($album->private)
                                <i class="fa fa-check" aria-hidden="true"></i>
                            @else
                                <i class="fa fa-times" aria-hidden="true"></i>
                            @endif
                        </a>
                    </td>

                </tr>

            @endforeach

        </table>

    @else

        <p style="text-align: center;">
            There are no albums.
        </p>

    @endif

@endsection