@extends('website.layouts.default-nobg')

@section('page-title')
    {{ $page->title }}
@endsection

@section('content')

    <div class="row">

        <div class="@if($page->featuredImage || $page->files->count() > 0) col-md-8 @else col-md-12 @endif">

                <div class="page-show__content">
                    {!! $parsedContent !!}
                </div>

            </div>

        @if($page->featuredImage || $page->files->count() > 0)

            <div class="col-md-4">

                @if($page->featuredImage)
                    <div class="panel panel-default" style="box-shadow: 0 0 20px;">
                        <img src="{{ $page->featuredImage->generateImagePath('600', null) }}" class="img-responsive" />
                    </div>
                @endif

                    @if($page->files->count() > 0)

                    <div class="panel panel-default" style="box-shadow: 0 0 20px;">

                        <div class="panel-heading">

                            Attachments

                        </div>

                        <div class="panel-body">

                            @foreach($page->files as $file)

                                <p><i class="fa fa-paperclip" aria-hidden="true"></i> <a href="{{ $file->generatePath() }}" target="_blank">{{ $file->original_filename }}</a></p>

                            @endforeach

                        </div>

                    </div>

                    @endif

                </div>

        @endif

    </div>

@endsection