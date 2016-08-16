@extends('website.layouts.content')

@section('header')

    <div id="header">

        <div class="container">

            @section('greeting')
            @show

        </div>

    </div>

@endsection

@section('container')

    <div class="container" style="margin-top: 30px;">

        <div class="row">

            @section('visitor-specific')
            @show

            <div class="col-md-4">

                <div class="panel panel-default calendar__homepage">

                    <div class="panel-body calendar">

                        <h4 style="text-align: center;">
                            Upcoming activities
                        </h4>

                        <hr>

                        <? $week = date('W', $events[0]->start); ?>

                        @foreach($events as $key => $event)

                            @if($week != date('W', $event->start))
                                <hr>
                            @endif

                            <a class="activity"
                               href="{{ route('event::show', ['id' => $event->id]) }}">
                                <div class="activity {{ ($key % 2 == 1 ? 'odd' : '') }}" {!! ($event->secret ? 'style="opacity: 0.3;"' : '') !!}>
                                    <p><strong>{{ $event->title }}</strong></p>
                                    <p><i class="fa fa-map-marker" aria-hidden="true"></i> {{ $event->location }}
                                    </p>
                                    <p>
                                        <i class="fa fa-clock-o" aria-hidden="true"></i>
                                        {{ date('l j F', $event->start) }}, {{ date('H:i', $event->start) }} -
                                        @if (($event->end - $event->start) < 3600 * 24)
                                            {{ date('H:i', $event->end) }}
                                        @else
                                            {{ date('j M, H:i', $event->end) }}
                                        @endif
                                    </p>
                                </div>
                            </a>

                            <? $week = date('W', $event->start); ?>

                        @endforeach

                        <hr>

                    </div>

                </div>

            </div>

        </div>

        <hr>

        <h1 style="text-align: center; color: #fff; margin: 30px;">
            Recent photo albums
        </h1>

        <div class="row">

            @foreach(Flickr::getAlbums(6) as $key => $album)

                <div class="col-md-4 col-xs-6">

                    <a href="{{ route('photo::album::list', ['id' => $album->id]) }}" class="album-link">
                        <div class="album"
                             style="background-image: url('{!! $album->primary_photo_extras->url_m !!}')">
                            <div class="album-name">
                                {{ $album->title->_content }}
                            </div>
                        </div>
                    </a>

                </div>

            @endforeach

        </div>

    </div>

@endsection

@section('stylesheet')

    @parent

    <style type="text/css">

        .calendar__homepage {
            min-height: 300px;
            max-height: 300px;
            overflow: hidden;
        }

        .calendar__homepage:hover {
            max-height: none;
        }

    </style>

@endsection