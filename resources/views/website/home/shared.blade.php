@extends('website.layouts.content')

@section('page-title')
    Homepage
@endsection

@section('header')

    <div id="header" class="main__header">

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
        @section('visitor-specific')
        @show

        <h1 style="text-align: center; color: #fff; margin: 30px;">
            Recent <img src="{{ asset('images/application/protoink.png') }}" alt="/Proto/.Ink" width="160"> articles
        </h1>

        <div class="row">
            <div class="container">
                <div id="myCarousel" class="carousel slide panel panel-default" data-ride="carousel">

                  <!-- Wrapper for slides -->
                  <div class="carousel-inner">
                      @foreach($posts as $key => $post)
                        <div class="item @if ($post == reset($posts )) active @endif">
                          <img height="400" width="auto" src="{{ asset('images/protoink-placeholder.png') }}">
                           <div class="carousel-caption">
                            <h4><a href="{{$post->link}}">{{$post->title}}</a></h4>
                            <p class="medium-text">{{$post->description}}</p>
                          </div>
                        </div><!-- End Item -->
                    @endforeach
                  </div><!-- End Carousel Inner -->

                <ul class="list-group">
                @foreach($posts as $key => $post)
                  <li data-target="#myCarousel" data-slide-to="{{$key}}" class="list-group-item @if ($post == reset($posts )) active @endif">
                      <h5 style="margin-bottom: 0;">{{$post->title}}</h5>
                      <p><small>{{gmdate("d M Y", $post->date)}}</small></p>
                  </li>
                  @endforeach
                </ul>

                  <!-- Controls -->
                  <div class="carousel-controls">
                      <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left"></span>
                      </a>
                      <a class="right carousel-control" href="#myCarousel" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right"></span>
                      </a>
                  </div>

                </div><!-- End Carousel -->
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
                                {{ date('M j, Y', $album->date_taken) }}: {{ $album->name }}
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

        $(window).load(function() {
            var boxheight = $('#myCarousel .carousel-inner').innerHeight();
            var itemlength = $('#myCarousel .item').length;
            var triggerheight = Math.round(boxheight/itemlength+1);
        	$('#myCarousel .list-group-item').outerHeight(triggerheight);
        });

        $(document).ready(function () {
            var clickEvent = false;
            $('#myCarousel').carousel({
                interval:   4000
            }).on('click', '.list-group li', function() {
                    clickEvent = true;
                    $('.list-group li').removeClass('active');
                    $(this).addClass('active');
            }).on('slid.bs.carousel', function(e) {
                if(!clickEvent) {
                    var count = $('.list-group').children().length -1;
                    var current = $('.list-group li.active');
                    current.removeClass('active').next().addClass('active');
                    var id = parseInt(current.data('slide-to'));
                    if(count == id) {
                        $('.list-group li').first().addClass('active');
                    }
                }
                clickEvent = false;
            });

            setTimeout(function () {

                updateSlider();

                setInterval(doSlide, 10000);

                doSlide();

            }, 2500);

            var theater = theaterJS()

            theater
            .on('type:start, erase:start', function () {
              // add a class to actor's dom element when he starts typing/erasing
              var actor = theater.getCurrentActor()
              actor.$element.classList.add('is-typing')
            })
            .on('type:end, erase:end', function () {
              // and then remove it when he's done
              var actor = theater.getCurrentActor()
              actor.$element.classList.remove('is-typing')
            })

            theater
                .addActor('greeting')

            theater
                .addScene('greeting:Lorem Ipsum...', 400)
                .addScene('greeting:Dolor sit amet?', 400)
                .addScene(theater.replay)

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
