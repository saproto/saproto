@extends('website.layouts.redesign.dashboard')

@section('page-title')
    Page Admin
@endsection

@section('container')

    <div class="row justify-content-center">

        <div class="col-md-8">

            <div class="card mb-3">

                <div class="card-header bg-dark text-white">
                    @yield('page-title')
                    <a href="{{ route('page::add') }}" class="badge badge-info float-right">
                        Create a new page.
                    </a>
                </div>

                <table class="table table-sm table-hover">

                    <thead>

                    <tr class="bg-dark text-white">

                        <td>Title</td>
                        <td>URL</td>
                        <td>Visibility</td>
                        <td>Controls</td>

                    </tr>

                    </thead>

                    @foreach($pages as $page)

                        <tr>

                            <td>{{ $page->title }}</td>
                            <td><a href="{{ route('page::show', $page->slug) }}">{{ route('page::show', $page->slug) }}</a></td>
                            <td>@if($page->is_member_only) <i class="fas fa-lock"></i> @endif</td>
                            <td>
                                <a href="{{ route('page::edit', ['id' => $page->id]) }}">
                                    <i class="fas fa-edit mr-2"></i>
                                </a>

                                <a href="{{ route('page::delete', ['id' => $page->id]) }}" onclick="return confirm('Are you sure?')">
                                    <i class="fas fa-trash text-danger"></i>
                                </a>
                            </td>

                        </tr>

                    @endforeach

                </table>

                <div class="card-footer pb-0">
                    {!! $pages->links() !!}
                </div>

            </div>

        </div>

    </div>

@endsection