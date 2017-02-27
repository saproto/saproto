@extends('website.layouts.default-nobg')

@section('page-title')
    {{ $newsitem->title }}
@endsection

@section('content')
    
    <div class="row">

        <div class="col-md-12">

            <img src="{{ $newsitem->featuredImage->generateImagePath('1070', '300') }}" class="img-responsive" width="100%" />

            <div class="page-show__content">
                <p><em>Published on {{ date("d-m-Y") }}</em></p>
                {!! $parsedContent !!}
            </div>

        </div>

    </div>

@endsection