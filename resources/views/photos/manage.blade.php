@extends('website.layouts.default')

@section('page-title')
    Album Administration
@endsection

@section('content')

    @if (count($albums) > 0)

        <strong style="text-align:center; display:block;">Making an album for members only means it won't appear on places like the front page for non members, but anyone with the link can still visit it.</strong>

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