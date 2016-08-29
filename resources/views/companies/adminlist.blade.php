@extends('website.layouts.default')

@section('page-title')
    Company Administration
@endsection

@section('content')

    @if (count($companies) > 0)

        <p style="text-align: center;">
            <a href="{{ route('companies::add') }}">Create a new company.</a>
        </p>

        <table class="table">

            <thead>

            <tr>

                <th>#</th>
                <th>Name</th>
                <th>URL</th>
                <th>Visible</th>
                <th>Logo Bar</th>
                <th>Controls</th>

            </tr>

            </thead>

            @foreach($companies as $company)

                <tr>

                    <td>{{ $company->id }}</td>
                    <td>{{ $company->name }}</td>
                    <td><a href="{{ $company->url }}" target="_blank">{{ $company->url }}</a></td>
                    <td>{{ $company->on_carreer_page ? 'Yes' : 'No' }}</td>
                    <td>{{ $company->in_logo_bar ? 'Yes' : 'No' }}</td>
                    <td>
                        <a class="btn btn-xs btn-default"
                           href="{{ route('companies::edit', ['id' => $company->id]) }}" role="button">
                            <i class="fa fa-pencil" aria-hidden="true"></i>
                        </a>
                        <a class="btn btn-xs btn-danger"
                           href="{{ route('companies::delete', ['id' => $company->id]) }}" role="button">
                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                        </a>
                    </td>

                </tr>

            @endforeach

        </table>

    @else

        <p style="text-align: center;">
            There are no companies in the system.
            <a href="{{ route('companies::add') }}">Create a new company.</a>
        </p>

    @endif

@endsection