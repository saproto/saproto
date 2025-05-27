@extends('website.layouts.redesign.generic')

@section('page-title')
    {{ $category->title }} Board Archive
@endsection

@section('container')
    <div class="row">
        <div class="col-12">
            <div class="card mx-4 mb-3">
                <div class="card-header bg-dark text-white">
                    <span class="float-left m-0">
                        <i class="fas fa-archive me-2 text-white"></i>
                        Archived {{ $category->title }}
                    </span>
                    <a
                        href="{{ route('feedback::index', ['category' => $category->url]) }}"
                        class="btn btn-info float-end ms-3 px-2 py-1"
                    >
                        <i class="fas fa-eye text-white"></i>
                        <span class="d-none d-sm-inline">View Public</span>
                    </a>
                </div>

                <div class="card-body">
                    @if (count($data) > 0)
                        <div class="row">
                            @foreach ($data as $key => $entry)
                                <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                                    @include(
                                        'feedbackboards.include.feedback',
                                        [
                                            'feedback' => $entry,
                                            'controls' => true,
                                        ]
                                    )
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="mt-3 text-center text-muted">
                            No archived {{ $category->title }}.
                        </p>
                    @endif
                </div>

                @if ($data->links() != '')
                    <div class="card-footer">
                        {{ $data->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
