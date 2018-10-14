@extends('website.layouts.default')

@section('page-title')
    Achievement Administration
@endsection

@section('content')

    @if (count($achievements) > 0)

        <strong class="visible-sm visible-xs" style="text-align: center;">- Some columns have been hidden because the screen is too small -</strong>

        <table class="table achievement-admin-list">

            <thead>

                <tr>

                    <th class="hidden-sm hidden-xs">#</th>
                    <th class="hidden-sm hidden-xs">Icon</th>
                    <th>Title</th>
                    <th class="hidden-sm hidden-xs">Description</th>
                    <th class="hidden-sm hidden-xs">Tier</th>
                    <th>Controls</th>

                </tr>

            </thead>

            @foreach($achievements as $achievement)

                <tr>

                    <td class="hidden-sm hidden-xs">{{ $achievement->id }}</td>
                    <td class="hidden-sm hidden-xs {{ $achievement->tier }}">
                        @if($achievement->fa_icon)
                            <div><i class="{{ $achievement->fa_icon }}" aria-hidden="true"></i></div>
                        @else
                            No icon available
                        @endif
                    </td>
                    <td>{{ $achievement->name }}</td>
                    <td class="hidden-sm hidden-xs">{{ $achievement->desc }}</td>
                    <td class=" hidden-sm hidden-xs {{ $achievement->tier }}">{{ $achievement->tier }}</td>
                    <td>
                        <a class="btn btn-xs btn-default"
                           href="{{ route('achievement::manage', ['id' => $achievement->id]) }}" role="button">
                            <i class="fas fa-bars" aria-hidden="true"></i>
                        </a>
                        <a class="btn btn-xs btn-danger"
                           href="{{ route('achievement::delete', ['id' => $achievement->id]) }}" role="button">
                            <i class="fas fa-trash-o" aria-hidden="true"></i>
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