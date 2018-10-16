@extends('website.layouts.redesign.generic-sidebar')

@section('page-title')
    Videos
@endsection

@section('container')

    <div class="card">

        <div class="card-body">

            <div class="row">

                @foreach($videos as $key => $video)

                    <div class="col-md-3 col-sm-4 col-xs-12">

                        @include('website.layouts.macros.card-bg-image', [
                            'url' => route('video::view', ['id'=> $video->id]),
                            'img' => $video->youtube_thumb_url,
                            'html' => sprintf('<em>%s</em><br><strong><i class="fas fa-fw fa-play" aria-hidden="true"></i> %s</strong>', date("M j, Y", strtotime($video->video_date)), $video->title)
                        ])

                    </div>

                @endforeach

            </div>

        </div>

    </div>

@endsection


