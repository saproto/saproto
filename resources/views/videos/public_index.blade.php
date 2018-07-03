@extends('website.layouts.default-nobg')

@section('page-title')
    Videos
@endsection

@section('content')

    @foreach($videos as $key => $video)

            @include('videos.include', ['colsize'=> 4, 'video' => $video])

    @endforeach

@endsection


