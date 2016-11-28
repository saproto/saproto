@extends('website.layouts.default')

@section('page-title')
    Achievement Administration
@endsection

@section('content')

    @if (count($achievements) > 0)

        <table class="table achievement-admin-list">

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
                    <td class="{{ $achievement->tier }}">
                        @if($achievement->fa_icon)
                            <div><i class="{{ $achievement->fa_icon }}" aria-hidden="true"></i></div>
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