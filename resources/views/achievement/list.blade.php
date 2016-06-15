@extends('website.layouts.default')

@section('page-title')
    Achievement Administration
@endsection

@section('content')

    @if (count($achievements) > 0)

        <table class="table">

            <thead>

            <tr>

                <th>#</th>
                <th>Icon</th>
                <th>Title</th>
                <th>Description</th>
                <th>Tier</th>
                <th>Controls</th>

            </tr>

            </thead>

            @foreach($achievements as $achievement)

                <tr>

                    <td>{{ $achievement->id }}</td>
                    <td><img src="{{ $achievement->img_file_id }}" alt=""></td>
                    <td>{{ $achievement->name }}</td>
                    <td>{{ $achievement->desc }}</td>
                    <td>{{ $achievement->tier }}</td>
                    <td>
                        <a class="btn btn-xs btn-default"
                           href="{{ route('achievement::edit', ['id' => $achievement->id]) }}" role="button">
                            <i class="fa fa-pencil" aria-hidden="true"></i>
                        </a>
                        <a class="btn btn-xs btn-danger"
                           href="{{ route('achievement::delete', ['id' => $achievement->id]) }}" role="button">
                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                        </a>
                    </td>

                </tr>

            @endforeach

        </table>

        <p style="text-align: center;">
            <a href="{{ route('achievement::add') }}">Create a new achievement.</a>
        </p>

    @else

        <p style="text-align: center;">
            There are no achievements.
            <a href="{{ route('achievement::add') }}">Create a new achievement.</a>
        </p>

    @endif

@endsection