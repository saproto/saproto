@extends('website.layouts.default')

@section('page-title')
    News Admin
@endsection

@section('content')

    @if (count($newsitems) > 0)

        <table class="table">

            <thead>

            <tr>

                <th>Title</th>
                <th width="25px">Published</th>
                <th width="25px">Controls</th>

            </tr>

            </thead>

            @foreach($newsitems as $newsitem)

                <tr>

                    <td>{{ $newsitem->title }}</td>
                    <td>@if($newsitem->isPublished()) <strong>published</strong> @endif</td>
                    <td>
                        <a class="btn btn-xs btn-default"
                           href="{{ route('news::edit', ['id' => $newsitem->id]) }}" role="button">
                            <i class="fa fa-pencil" aria-hidden="true"></i>
                        </a>

                        <a class="btn btn-xs btn-danger"
                           href="{{ route('news::delete', ['id' => $newsitem->id]) }}" role="button">
                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                        </a>
                    </td>

                </tr>

            @endforeach

        </table>

        <p style="text-align: center;">
            <a href="{{ route('news::add') }}">Create a new news item.</a>
        </p>

    @else

        <p style="text-align: center;">
            There are currently no pages.
            <a href="{{ route('news::add') }}">Create a new news item.</a>
        </p>

    @endif

@endsection