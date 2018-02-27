@extends('website.layouts.default-nobg')

@section('page-title')
    {{ $newsitem->title }}
@endsection

@section('content')

    @if($preview) <div class="alert alert-info" role="alert">You are currently previewing an unpublished news item.</div> @endif

    <div class="row">

        <div class="col-md-12">

            @if($newsitem->featuredImage) <img src="{{ $newsitem->featuredImage->generateImagePath('1070', '300') }}" class="img-responsive" width="100%" /> @endif

            <div class="news-show__content">
                <p><em>Published <span title="{{ $newsitem->published_at }}">{{ Carbon::parse($newsitem->published_at)->diffForHumans() }}</span> by <a href="{{ route('user::profile', ['id' => $newsitem->user->getPublicId()]) }}">{{ $newsitem->user->name }}</a></em></p>
                {!! $parsedContent !!}
            </div>

        </div>

    </div>

@endsection