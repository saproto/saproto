@extends('website.layouts.default')

@section('page-title')
    ProTube Dashboard
@endsection

@section('content')
    <div class="row">

        <div class="col-md-4">
            <p>
                <a href="{{ route('protube::top') }}" class="btn btn-success" style="width: 100%">
                    View the ProTube top hits!
                </a>
            </p>

            <hr>

            <h4>ProTube Settings</h4>

            <p>
                ProTube can keep your history. This means that if you play a song using ProTube, and if you are logged
                in to the website in that browser, it will remember you put that song in the queue. This enables us to
                generate a top hits list for you personally, and we have plans to also allow you to sync your own
                personalized Spotify playlist. None of this information is shared with other people.
            </p>

            <hr>

            <p>
                ProTube is currently <strong>{{$user->keep_protube_history ? '' : 'not' }}</strong> keeping your
                history.
            </p>
            @if($user->keep_protube_history)
                <a href="{{ route('protube::togglehistory') }}" class="btn btn-danger" style="width: 100%;">
                    Stop keeping my ProTube history.
                </a>
            @else
                <a href="{{ route('protube::togglehistory') }}" class="btn btn-success" style="width: 100%;">
                    Start keeping my ProTube history.
                </a>
            @endif

            <hr>

            <p>
                You have put <strong>{{ $usercount }}</strong> songs in ProTube. You can anonimyze your history. We will
                keep the songs for historic purposes, but we will remove your name from them. This action is
                irreversible.
            </p>

            <a href="{{ route('protube::clearhistory') }}" class="btn btn-danger"
               onclick="return confirm('Are you sure?');" style="width: 100%;">
                Clear my ProTube history.
            </a>

            <hr>

            <ul class="list-group">
                <li class="list-group-item list-group-item-success">
                    <strong>
                        Your personal top list!
                    </strong>
                </li>
                @if(count($usertop) == 0)
                    <li class="list-group-item">
                        You have played videos.
                    </li>
                @else
                    @foreach($usertop as $video)
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

        <div class="col-md-8">
            <h4>ProTube History</h4>
            <table class="table">
                <thead>
                <tr>
                    <th width="140px">Time</th>
                    <th>Video</th>
                    <th>&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                @foreach($history as $video)
                    <tr>
                        <td>{{ date('d M H:i:s', strtotime($video->played_at)) }}</td>
                        <td>
                            <a href="{{ PlayedVideo::generateYoutubeUrl($video->video_id) }}" target="_blank">
                                {{ $video->video_title }}
                            </a>
                        </td>
                        <td></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    </div>
@endsection