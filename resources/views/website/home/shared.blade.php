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
                  <div class="carousel-inner" id="carouselItems"></div><!-- End Carousel Inner -->

                <ul class="list-group" id="carouselList">

                </ul>

                  <!-- Controls -->
                  <div class="carousel-controls">
                      <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                        <i class="fa fa-chevron-left" aria-hidden="true"></i>
                      </a>
                      <a class="right carousel-control" href="#myCarousel" data-slide="next">
                        <i class="fa fa-chevron-right" aria-hidden="true"></i>
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

            $.ajax({
                type: 'GET',
                url: '/api/protoink',
                dataType: 'json',
                success: function (data) {
                    $.each(data, function(index, element) {
                        $('#carouselItems').append('<div class="item" id="carouselItem"><img height="400" width="auto" src="{{ asset('images/protoink-placeholder.png') }}"><div class="carousel-caption"><h4><a href="' + element.link + '">' + element.title + '</a></h4><p class="medium-text">' + element.description + '</p></div></div>');
                        $('#carouselList').append('<li data-target="#myCarousel" id="carouselListItem" data-slide-to="'+index+'" class="list-group-item"><h5 style="margin-bottom: 0;">' + element.title + '</h5><p><small>' +$.format.date(new Date(element.date*1000), "d MMM yyyy") + '</small></p></li>');
                        $("#carouselItem").first().addClass('active');
                        $("#carouselListItem").first().addClass('active');
                    });

                    if(data.length < 1) {
                        $("#myCarousel").html('Something went wrong loading the ProtoInk articles!');
                    }
                },
                error: function(xhr, textStatus, errorThrown) {
                    $("#myCarousel").html('Something went wrong loading the ProtoInk articles!');
                }
            });
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
