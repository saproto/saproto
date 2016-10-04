@extends('website.layouts.content')

@section('page-title')
    Homepage
@endsection

@section('header')

    <div id="header">

        <div class="container">

            @section('greeting')
            @show

        </div>

    </div>

@endsection

@section('container')

    @if(count($companies) > 0)

        <div class="row homepage__companyrow">

            <div class="homepage__companyrow__inner">

                @foreach($companies as $company)

                    <a href="{{ route('companies::show', ['id' => $company->id]) }}">
                        <img class="homepage__companyimage"
                             src="{{ $company->image->generateImagePath(null, 50) }}">
                    </a>

                @endforeach

            </div>

        </div>

    @endif

    <div class="container" style="margin-top: 30px;">

        <div class="row">

            @section('visitor-specific')
            @show

            <div class="col-md-4">

                <div class="panel panel-default homepage__calendar">

                    <div class="panel-body calendar">

                        <h4 style="text-align: center;">
                            Upcoming activities
                        </h4>

                        <hr>

                        <?php $week = date('W', $events[0]->start); ?>

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

                            <?php $week = date('W', $event->start); ?>

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
                             style="background-image: url('{!! $album->thumb !!}')">
                            <div class="album-name">
                                {{ $album->name }}
                            </div>
                        </div>
                    </a>

                </div>

            @endforeach

        </div>

    </div>

@endsection

@section('javascript')

    @parent

    <script type="application/javascript">

        var sliderDelta = 0;
        var oneWayOrTheOther = true;

        $(document).ready(function () {

            setTimeout(function () {

                updateSlider();

                setInterval(doSlide, 10000);

                doSlide();

            }, 2500);

        });

        $(window).resize(updateSlider);

        function doSlide() {

            if (sliderDelta < 0) {
                if (oneWayOrTheOther) {
                    $(".homepage__companyrow__inner").css('left', sliderDelta + 'px');
                } else {
                    $(".homepage__companyrow__inner").css('left', '0px');
                }
            }

            oneWayOrTheOther = !oneWayOrTheOther;

        }

        setInterval(updateSlider, 1);

        function updateSlider() {
            sliderDelta = $(".homepage__companyrow").width() - $(".homepage__companyrow__inner").width() - 40;
        }

    </script>

@endsection
