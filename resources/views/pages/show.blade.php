@extends('website.layouts.redesign.generic-sidebar')

@section('page-title')
    {{ $page->title }}
@endsection

@section('container')

    <div class="card">

        @if($page->featuredImage)
            <img class="card-img-top" src="{{ $page->featuredImage->generateImagePath('1000', '200') }}"
                 style="width: 100%;">
        @endif

        <div class="card-body">
            <h5 class="card-title">@yield('page-title')</h5>
            <p class="card-text">

            {!! $parsedContent !!}

            @if($page->files->count() > 0 && $page->show_attachments)

                <hr>

                <p>
                    <strong>Attachments</strong>
                </p>

                @foreach($page->files as $file)

                    <a href="{{ $file->generatePath() }}"                       target="_blank" class="card-link">
                        <i class="fa fa-paperclip" aria-hidden="true"></i> {{ $file->original_filename }}
                    </a>

                @endforeach

            @endif

            </p>
        </div>
    </div>

@endsection
