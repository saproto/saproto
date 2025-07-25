@extends('website.layouts.redesign.dashboard')

@section('page-title')
    Company Administration
@endsection

@section('container')
    <div id="companies-admin" class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-header bg-dark mb-1 text-white">
                    @yield('page-title')
                    <a
                        href="{{ route('companies::create') }}"
                        class="badge bg-info float-end"
                    >
                        Create a new company.
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table-sm table-hover table">
                        <thead>
                            <tr class="bg-dark text-white">
                                <td>Name</td>
                                <td>URL</td>
                                <td>Visible</td>
                                <td>Logo Bar</td>
                                <td>Controls</td>
                            </tr>
                        </thead>

                        @foreach ($companies as $company)
                            <tr>
                                <td class="name">{{ $company->name }}</td>
                                <td class="url">
                                    <a
                                        href="{{ $company->url }}"
                                        target="_blank"
                                    >
                                        {{ $company->url }}
                                    </a>
                                </td>
                                <td class="on-carreer-page">
                                    {{ $company->on_carreer_page ? '✅' : '❌' }}
                                </td>
                                <td class="in-logo-bar">
                                    {{ $company->in_logo_bar ? '✅' : '❌' }}
                                </td>
                                <td>
                                    <a
                                        href="{{ route('companies::edit', ['id' => $company->id]) }}"
                                    >
                                        <i class="fas fa-edit fa-fw me-2"></i>
                                    </a>

                                    @include(
                                        'components.modals.confirm-modal',
                                        [
                                            'action' => route('companies::delete', ['id' => $company->id]),
                                            'text' => '<i class="fas fa-trash me-2 fa-fw text-danger"></i>',
                                            'title' => 'Confirm Delete',
                                            'message' => "Are you sure you want to delete $company->name?",
                                            'confirm' => 'Delete',
                                        ]
                                    )

                                    @if ($company->sort > 0)
                                        <a
                                            href="{{ route('companies::orderUp', ['id' => $company->id]) }}"
                                        >
                                            <i
                                                class="fas fa-arrow-up fa-fw text-info me-2"
                                            ></i>
                                        </a>
                                    @endif

                                    @if ($company->sort != $companies->count())
                                        <a
                                            href="{{ route('companies::orderDown', ['id' => $company->id]) }}"
                                        >
                                            <i
                                                class="fas fa-arrow-down fa-fw text-info me-2"
                                            ></i>
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
