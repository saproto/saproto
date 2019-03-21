@extends('website.layouts.redesign.generic')

@section('page-title')
    {{ $page->title }}
@endsection

@section('container')

    <div class="row justify-content-center">

        <div class="col-xl-8 col-lg-10 col-md-12 col-sm-12">

    <div class="card mb-3">

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
                        <i class="fas fa-paperclip" aria-hidden="true"></i> {{ $file->original_filename }}
                    </a>

                @endforeach

            @endif

            </p>
        </div>
    </div>

    </div>

    </div>

@endsection
