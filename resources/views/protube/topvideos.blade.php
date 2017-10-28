@extends('website.layouts.default')

@section('page-title')
    ProTube Hits
@endsection

@section('content')
    <div class="row">
        @foreach($data as $period => $content)
            <div class="col-md-4">
                <ul class="list-group">
                    <a href="https://open.spotify.com/user/studyassociationproto/playlist/213N4HAIKNZe7H0X3R79I2"
                       target="_blank" class="list-group-item list-group-item-success">
                        <i class="fa fa-spotify" aria-hidden="true"></i> Get the ProTube Hits Spotify playlist!
                    </a>
                    <li class="list-group-item">
                        <strong>
                            @if ($period == 'alltime')
                                All-time
                            @elseif($period == 'month')
                                Last Months
                            @elseif($period == 'week')
                                Last Weeks
                            @endif
                            Top 10
                        </strong>
                    </li>
                    @if(count($content) == 0)
                        <li class="list-group-item">
                            This list is currently empty.
                        </li>
                    @else
                        @foreach($content as $video)
                            <li class="list-group-item protube__dashboard__video">
                                @if(!empty($video->spotify_id ))
                                    {{ $video->spotify_name }}
                                @else
                                    {{ $video->video_title }}
                                @endif
                                <br>
                                <sup>Played {{ $video->played_count }} times.</sup>
                                <br>
                                <a href="{{ PlayedVideo::generateYoutubeUrl($video->video_id) }}"
                                   target="_blank" class="btn btn-xs btn-danger">
                                    <i class="fa fa-youtube-play" aria-hidden="true"></i> Watch on YouTube
                                </a>
                                @if(!empty($video->spotify_id))
                                    <a href="{{ PlayedVideo::generateSpotifyUri($video->spotify_id) }}"
                                       target="_blank" class="btn btn-xs btn-success">
                                        <i class="fa fa-spotify" aria-hidden="true"></i> Listen on Spotify
                                    </a>
                                @endif
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
        @endforeach
    </div>
@endsection