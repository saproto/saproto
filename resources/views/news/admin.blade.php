@extends('website.layouts.redesign.dashboard')

@section('page-title')
    News Admin
@endsection

@section('container')

    <div class="row justify-content-center">

        <div class="col-md-6">

            <div class="card mb-3">

                <div class="card-header bg-dark text-white mb-1">
                    @yield('page-title')
                    <a href="{{ route('news::add') }}" class="badge badge-info float-right">
                        Create a new news item.
                    </a>
                </div>

                <div class="table-responsive">

                    <table class="table table-sm table-hover">

                        <thead>

                        <tr class="bg-dark text-white">

                            <td>Title</td>
                            <td>Published</td>
                            <td>Controls</td>

                        </tr>

                        </thead>

                        @foreach($newsitems as $newsitem)

                            <tr>

                                <td style="overflow-wrap: break-word; max-width: 160px">{{ $newsitem->title }}</td>
                                <td>@if($newsitem->isPublished()) <span class="text-primary">{{ $newsitem->published_at }}</span> @else <span class="text-muted">{{ $newsitem->published_at }}</span> @endif</td>
                                <td>
                                    <a href="{{ route('news::show', ['id' => $newsitem->id]) }}">
                                        <i class="fas fa-link mr-2"></i>
                                    </a>

                                    <a href="{{ route('news::edit', ['id' => $newsitem->id]) }}">
                                        <i class="fas fa-edit mr-2"></i>
                                    </a>

                                    <a href="{{ route('news::delete', ['id' => $newsitem->id]) }}" onclick="return confirm('Are you sure?')">
                                        <i class="fas fa-trash text-danger"></i>
                                    </a>
                                </td>

                            </tr>

                        @endforeach

                    </table>

                </div>

                <div class="card-footer pb-0">
                    {!! $newsitems->links() !!}
                </div>

            </div>

        </div>

    </div>

@endsection