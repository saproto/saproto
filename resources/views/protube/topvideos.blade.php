@extends('website.layouts.redesign.generic-sidebar')

@section('page-title')
    ProTube Hits
@endsection

@section('container')

    <a href="https://open.spotify.com/user/studyassociationproto/playlist/213N4HAIKNZe7H0X3R79I2"
       target="_blank" class="btn btn-primary btn-block btn-lg mb-3">
        <i class="fab fa-spotify fa-fw mr-3" aria-hidden="true"></i> Get the ProTube Hits Spotify playlist!
    </a>

    <div class="row">

        @foreach($data as $period => $content)

            <div class="col-md-4">

                <div class="card">

                    <div class="card-header">

                        @if ($period == 'alltime')
                            All-time
                        @elseif($period == 'month')
                            Last Months
                        @elseif($period == 'week')
                            Last Weeks
                        @endif
                        Top 10

                    </div>

                    <div class="card-body">

                        @if(count($content) == 0)

                            <p class="card-text">
                                This list is currently empty.
                            </p>

                        @else

                            @foreach($content as $video)

                                <div class="card mb-3">
                                    <div class="card-body">
                                        <p class="card-text ellipsis">

                                            <strong>
                                                <i class="fas fa-music fa-fw mr-2"></i>
                                                @if(!empty($video->spotify_id ))
                                                    {{ $video->spotify_name }}
                                                @else
                                                    {{ $video->video_title }}
                                                @endif
                                            </strong>

                                            <br>

                                            <span class="text-muted">
                                                <em>Played {{ $video->played_count }} times.</em>
                                            </span>

                                        </p>

                                        <div class="row">

                                            <div class="col-6">

                                                <a href="{{ PlayedVideo::generateYoutubeUrl($video->video_id) }}"
                                                   target="_blank" class="btn btn-xs btn-danger btn-block btn-sm">
                                                    <i class="fab fa-youtube" aria-hidden="true"></i> Watch on YouTube
                                                </a>

                                            </div>

                                            <div class="col-6">

                                                @if(!empty($video->spotify_id))
                                                    <a href="{{ PlayedVideo::generateSpotifyUri($video->spotify_id) }}"
                                                       target="_blank" class="btn btn-xs btn-success btn-block btn-sm">
                                                        <i class="fab fa-spotify" aria-hidden="true"></i> Listen on
                                                        Spotify
                                                    </a>
                                                @endif

                                            </div>

                                        </div>

                                    </div>
                                </div>

                            @endforeach

                        @endif

                    </div>

                </div>

            </div>

        @endforeach

    </div>

@endsection