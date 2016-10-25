@extends('website.layouts.default')

@section('page-title')
    Job offer Administration
@endsection

@section('content')

    @if (count($joboffers) > 0)

        <p style="text-align: center;">
            <a href="{{ route('joboffers::add') }}">Create a new job offer.</a>
        </p>

        <table class="table">

            <thead>

            <tr>

                <th>#</th>
                <th>Company</th>
                <th>Title</th>
                <th>Controls</th>

            </tr>

            </thead>

            @foreach($joboffers as $joboffer)

                <tr>

                    <td>{{ $joboffer->id }}</td>
                    <td>{{ $joboffer->company->name }}</td>
                    <td>{{ $joboffer->title}}</td>

                    <td>
                        <a class="btn btn-xs btn-default"
                           href="{{ route('joboffers::edit', ['id' => $joboffer->id]) }}" role="button">
                            <i class="fa fa-pencil" aria-hidden="true"></i>
                        </a>
                        <a class="btn btn-xs btn-danger"
                           href="{{ route('joboffers::delete', ['id' => $joboffer->id]) }}" role="button">
                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                        </a>
                    </td>

                </tr>

            @endforeach

        </table>

    @else

        <p style="text-align: center;">
            There are no job offers in the system.
            <a href="{{ route('joboffers::add') }}">Create a new job offer.</a>
        </p>

    @endif

@endsection