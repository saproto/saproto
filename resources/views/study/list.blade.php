@extends('website.layouts.default')

@section('page-title')
    Study Administration
@endsection

@section('content')

    @if (count($studies) > 0)

        <strong class="visible-sm visible-xs" style="text-align: center;">- Some columns have been hidden because the screen is too small -</strong>

        <table class="table">

            <thead>

                <tr>

                    <th class="hidden-sm hidden-xs">#</th>
                    <th class="hidden-sm hidden-xs">Type</th>
                    <th>Study</th>
                    <th class="hidden-sm hidden-xs">Faculty</th>
                    <th class="hidden-sm hidden-xs">Institution</th>
                    <th>Controls</th>

                </tr>

            </thead>

            @foreach($studies as $study)

                <tr>

                    <td class="hidden-sm hidden-xs">{{ $study->id }}</td>
                    <td class="hidden-sm hidden-xs">{{ $study->type }}</td>
                    <td>{{ $study->name }}</td>
                    <td class="hidden-sm hidden-xs">{{ $study->faculty }}</td>
                    <td class="hidden-sm hidden-xs">{{ ($study->utwente ? 'University of Twente' : 'External' ) }}</td>
                    <td>
                        <a class="btn btn-xs btn-default"
                           href="{{ route('study::edit', ['id' => $study->id]) }}" role="button">
                            <i class="fa fa-pencil" aria-hidden="true"></i>
                        </a>
                        <a class="btn btn-xs btn-danger"
                           href="{{ route('study::delete', ['id' => $study->id]) }}" role="button">
                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                        </a>
                    </td>

                </tr>

            @endforeach

        </table>

        <p style="text-align: center;">
            <a href="{{ route('study::add') }}">Create a new study.</a>
        </p>

    @else

        <p style="text-align: center;">
            There are no studies.
            <a href="{{ route('study::add') }}">Create a new study.</a>
        </p>

    @endif

@endsection