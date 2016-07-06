@extends('website.layouts.default')

@section('page-title')
    Page Admin
@endsection

@section('content')

    @if (count($pages) > 0)

        <table class="table">

            <thead>

            <tr>

                <th>Title</th>
                <th>URL</th>
                <th>Member only</th>
                <th>Controls</th>

            </tr>

            </thead>

            @foreach($pages as $page)

                <tr>

                    <td>{{ $page->title }}</td>
                    <td><a href="{{ route('page::show', $page->slug) }}">{{ route('page::show', $page->slug) }}</a></td>
                    <td>@if($page->is_member_only) Member only @else Public @endif</td>
                    <td>
                        <a class="btn btn-xs btn-default"
                           href="{{ route('page::edit', ['id' => $page->id]) }}" role="button">
                            <i class="fa fa-pencil" aria-hidden="true"></i>
                        </a>

                        <a class="btn btn-xs btn-danger"
                           href="{{ route('page::delete', ['id' => $page->id]) }}" role="button">
                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                        </a>
                    </td>

                </tr>

            @endforeach

        </table>

        <p style="text-align: center;">
            <a href="{{ route('page::add') }}">Create a new page.</a>
        </p>

    @else

        <p style="text-align: center;">
            There are currently no pages.
            <a href="{{ route('page::add') }}">Create a new page.</a>
        </p>

    @endif

@endsection