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

                                @include('protube.includes.song_block', [
                                    'video' => $video
                                ])

                            @endforeach

                        @endif

                    </div>

                </div>

            </div>

        @endforeach

    </div>

@endsection