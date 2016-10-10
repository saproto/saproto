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
                    <td>
                        @if($achievement->image)
                            <img src="{!! $achievement->image->generateImagePath(700,null) !!}" alt="">
                        @else
                            No icon available
                        @endif
                    </td>
                    <td>{{ $achievement->name }}</td>
                    <td>{{ $achievement->desc }}</td>
                    <td class="{{ $achievement->tier }}">{{ $achievement->tier }}</td>
                    <td>
                        <a class="btn btn-xs btn-default"
                           href="{{ route('achievement::manage', ['id' => $achievement->id]) }}" role="button">
                            <i class="fa fa-bars" aria-hidden="true"></i>
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