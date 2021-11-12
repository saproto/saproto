@extends('website.layouts.redesign.dashboard')

@section('page-title')
    Company Administration
@endsection

@section('container')

    <div class="row justify-content-center">

        <div class="col-md-8">

            <div class="card mb-3">

                <div class="card-header bg-dark text-white mb-1">
                    @yield('page-title')
                    <a href="{{ route('companies::add') }}" class="badge badge-info float-end">
                        Create a new company.
                    </a>
                </div>

                <div class="table-responsive">

                    <table class="table table-sm table-hover">

                        <thead>

                        <tr class="bg-dark text-white">

                            <td>Name</td>
                            <td>URL</td>
                            <td>Visible</td>
                            <td>Logo Bar</td>
                            <td>Controls</td>

                        </tr>

                        </thead>

                        @foreach($companies as $company)

                            <tr>

                                <td style="overflow-wrap: break-word; max-width: 130px">{{ $company->name }}</td>
                                <td style="overflow-wrap: break-word; max-width: 220px"><a href="{{ $company->url }}" target="_blank">{{ $company->url }}</a></td>
                                <td>{{ $company->on_carreer_page ? 'Yes' : 'No' }}</td>
                                <td>{{ $company->in_logo_bar ? 'Yes' : 'No' }}</td>
                                <td>

                                    <a href="{{ route('companies::edit', ['id' => $company->id]) }}">
                                        <i class="fas fa-edit me-2 fa-fw"></i>
                                    </a>

                                    <a href="{{ route('companies::delete', ['id' => $company->id]) }}"
                                       onclick="return confirm('Are you sure you want to delete this company?')">
                                        <i class="fas fa-trash me-2 fa-fw text-danger"></i>
                                    </a>

                                    @if($company->sort > 0)
                                        <a href="{{ route('companies::orderUp', ['id' => $company->id]) }}">
                                            <i class="fas fa-arrow-up me-2 fa-fw text-info"></i>
                                        </a>
                                    @endif

                                    @if($company->sort != $companies->count())
                                        <a href="{{ route('companies::orderDown', ['id' => $company->id]) }}">
                                            <i class="fas fa-arrow-down me-2 fa-fw text-info"></i>
                                        </a>
                                    @endif

                                </td>

                            </tr>

                        @endforeach

                    </table>

                </div>

                <div class="card-footer">
                    {!! $companies->links() !!}
                </div>

            </div>

        </div>

    </div>

@endsection