@extends('website.layouts.default-nobg')

@section('page-title')
    Videos
@endsection

@section('content')

    @foreach($videos as $key => $video)

        @include('website.layouts.macros.card-bg-image', [
            'url' => route('video::view', ['id'=> $video->id]),
            'img' => $video->youtube_thumb_url,
            'html' => sprintf('<em>%s</em><br><strong><i class="fas fa-fw fa-play" aria-hidden="true"></i> %s</strong>', date("M j, Y", strtotime($video->video_date)), $video->title)
        ])

    @endforeach

@endsection


