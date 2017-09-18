@extends('website.layouts.default-nobg')

@section('page-title')
    {{ $page->title }}
@endsection

@section('content')

    <div class="row">

        <div class="@if($page->featuredImage) col-md-8 @else col-md-12 @endif">

            <div class="page-show__content">
                {!! $parsedContent !!}
            </div>

        </div>

        @if($page->featuredImage)

            <div class="col-md-4">

                @if($page->featuredImage)
                    <div class="panel panel-default">
                        <img src="{{ $page->featuredImage->generateImagePath('600', null) }}" class="img-responsive"/>
                    </div>
                @endif

            </div>

        @endif

    </div>

@endsection
