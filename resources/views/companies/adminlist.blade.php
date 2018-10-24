@extends('website.layouts.redesign.dashboard')

@section('page-title')
    Company Administration
@endsection

@section('container')

    <div class="row justify-content-center">

        <div class="col-md-8">

            <div class="card mb-3">

                <div class="card-header bg-dark text-white">
                    @yield('page-title')
                    <a href="{{ route('companies::add') }}" class="badge badge-info float-right">
                        Create a new company.
                    </a>
                </div>

                <table class="table table-sm table-borderless table-hover">

                    <thead>

                    <tr>

                        <th class="pl-3">Name</th>
                        <th>URL</th>
                        <th>Visible</th>
                        <th>Logo Bar</th>
                        <th></th>

                    </tr>

                    </thead>

                    @foreach($companies as $company)

                        <tr>

                            <td class="pl-3">{{ $company->name }}</td>
                            <td><a href="{{ $company->url }}" target="_blank">{{ $company->url }}</a></td>
                            <td>{{ $company->on_carreer_page ? 'Yes' : 'No' }}</td>
                            <td>{{ $company->in_logo_bar ? 'Yes' : 'No' }}</td>
                            <td>

                                <a href="{{ route('companies::edit', ['id' => $company->id]) }}">
                                    <i class="fas fa-edit mr-2 fa-fw"></i>
                                </a>

                                <a href="{{ route('companies::delete', ['id' => $company->id]) }}"
                                   onclick="return confirm('Are you sure you want to delete this company?')">
                                    <i class="fas fa-trash mr-2 fa-fw text-danger"></i>
                                </a>

                                @if($company->sort > 0)
                                    <a href="{{ route('companies::orderUp', ['id' => $company->id]) }}">
                                        <i class="fas fa-arrow-up mr-2 fa-fw text-info"></i>
                                    </a>
                                @endif

                                @if($company->sort != $companies->count())
                                    <a href="{{ route('companies::orderDown', ['id' => $company->id]) }}">
                                        <i class="fas fa-arrow-down mr-2 fa-fw text-info"></i>
                                    </a>
                                @endif

                            </td>

                        </tr>

                    @endforeach

                </table>

                <div class="card-footer">
                    {!! $companies->links() !!}
                </div>

            </div>

        </div>

    </div>

@endsection