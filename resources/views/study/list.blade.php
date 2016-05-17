@extends('website.layouts.default')

@section('page-title')
    Study Administration
@endsection

@section('content')

    @if (count($studies) > 0)

        <table class="table">

            <thead>

            <tr>

                <th>#</th>
                <th>Type</th>
                <th>Study</th>
                <th>Faculty</th>
                <th>Institution</th>
                <th>Controls</th>

            </tr>

            </thead>

            @foreach($studies as $study)

                <tr>

                    <td>{{ $study->id }}</td>
                    <td>{{ $study->type }}</td>
                    <td>{{ $study->name }}</td>
                    <td>{{ $study->faculty }}</td>
                    <td>{{ ($study->utwente ? 'University of Twente' : 'External' ) }}</td>
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