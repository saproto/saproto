@extends('website.layouts.default-nobg')

@section('page-title')
    {{ $video->title }}
@endsection

@section('content')

    <p style="text-align: left; float: left; color: #fff;">
        From <span style="color: red;"><i class="fa fa-youtube-play" aria-hidden="true"></i> YouTube</span> &mdash;
        <a href="{{ $video->getYouTubeUrl() }}" class="underline-on-hover" target="_blank" style="color: #fff;">
            {{ $video->youtube_title }}
        </a>
        by
        <a href="{{ $video->getYouTubeChannelUrl() }}" target="_blank" style="color: #fff;" class="underline-on-hover">
            {{ $video->youtube_user_name }}
        </a>
    </p>

    @if($video->event)
        <p style="text-align: right; float: right; color: #fff;">
            <i class="fa fa-calendar" aria-hidden="true"></i>
            <a href="{{ route('event::show',['id'=>$video->event->getPublicId()]) }}"
               style="color: #fff;" class="underline-on-hover">
                {{  sprintf("%s (%s)",$video->event->title,date('d-m-Y', $video->event->start)) }}
            </a>
        </p>
    @endif

    <div class="clearfix"></div>

    <div class="embed-responsive embed-responsive-16by9">
        <iframe class="embed-responsive-item" src="{{ $video->getYouTubeEmbedUrl() }}" allowfullscreen></iframe>
    </div>

@endsection