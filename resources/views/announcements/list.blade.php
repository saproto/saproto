@extends('website.layouts.default')

@section('page-title')
    Announcements
@endsection

@section('content')

    @if (count($announcements) > 0)

        <table class="table">

            <thead>

            <tr>

                <th>#</th>
                <th></th>
                <th>Start</th>
                <th>End</th>
                <th>Visibility</th>
                <th></th>

            </tr>

            </thead>

            @foreach($announcements as $announcement)

                <tr {!! (!$announcement->showByTime() ? 'style="opacity: 0.5;"': '') !!}>

                    <td>{{ $announcement->id }}</td>
                    <td>{{ $announcement->description }}</td>
                    <td>{{ $announcement->display_from }}</td>
                    <td>{{ $announcement->display_till }}</td>
                    <td>{{ $announcement->textualVisibility() }}</td>
                    <td>
                        <a class="btn btn-xs btn-default"
                           href="{{ route('announcement::edit', ['id' => $announcement->id]) }}" role="button">
                            <i class="fas fa-pencil" aria-hidden="true"></i>
                        </a>
                        <a class="btn btn-xs btn-danger"
                           href="{{ route('announcement::delete', ['id' => $announcement->id]) }}" role="button">
                            <i class="fas fa-trash-o" aria-hidden="true"></i>
                        </a>
                    </td>

                </tr>

            @endforeach

        </table>

        <p style="text-align: center;">
            <a href="{{ route('announcement::add') }}">Add announcement</a> or <a
                    href="{{ route('announcement::clear') }}">delete all past announcements</a>.
        </p>

    @else

        <p style="text-align: center;">
            There are currently no announcements. <a href="{{ route('announcement::add') }}">Add announcement.</a>
        </p>

    @endif

@endsection