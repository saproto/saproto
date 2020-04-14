@extends('website.layouts.redesign.generic')

@section('stylesheet')
    @parent
    <link rel="stylesheet" href="https://unpkg.com/swiper/css/swiper.min.css">
@endsection

@section('head')
    @parent
    <script src="https://unpkg.com/swiper/js/swiper.min.js"></script>
@endsection

@section('page-title')
    Homepage
@endsection

@section('container')

    <div class="row">

        <div class="col-xl-9 col-md-6 col-sm-12">

            <div class="card text-white mb-3 border-0" style="height: 250px;
            @if($header)
                    background-image: url({{ $header->image->generateImagePath(1500, 400) }});
                    background-size: cover; background-position: center center;
                    text-shadow: 0 0 10px #000;
            @else
                    background-color: var(--primary);
                    height: 150px !important;
            @endif">
                @if($header && $header->user)
                    <small class="ellipsis text-right pr-3 pt-2">
                        @if (Auth::check() && Auth::user()->member && $header->user->member)
                            Photo by <a href="{{ route('user::profile', ['id' => $header->user->getPublicId()]) }}"
                                        class="text-white">
                                {{ $header->user->name }}</a>
                        @else
                            Photo by {{ $header->user->name }}
                        @endif
                    </small>
                @endif
                <div class="card-body"
                     style="text-align: left; vertical-align: bottom; font-size: 30px; display: flex;">
                    <p class="card-text ellipsis px-1" style="align-self: flex-end;">
                        @section('greeting')
                        @show
                    </p>
                </div>
            </div>

            @if(count($companies) > 0)

                <div class="card mb-3">
                    <div class="card-body pb-0 position-relative">
                        <div class="row mb-3 swiper-container" style="height:80px">
                            <div class="swiper-wrapper">
                                @foreach($companies as $i => $company)

                                    <div class="swiper-slide justify-content-center d-flex">
                                        <a href="{{ route('companies::show', ['id' => $company->id]) }}">
                                            <img src="{{ $company->image->generateImagePath(null, 50) }}">
                                        </a>
                                    </div>

                                @endforeach
                            </div>
                            <div class="swiper-scrollbar"></div>
                        </div>
                    </div>
                </div>

            @endif

            @section('left-column')
            @show

        </div>

        <div class="col-xl-3 col-md-6 col-sm-12">

            @if(isset($videos) && count($videos) > 0)

                <div class="card mb-3">
                    <div class="card-header bg-dark text-white">
                        <i class="fab fa-youtube fa-fw mr-2"></i> Recent videos
                    </div>
                    <div class="card-body">

                        @foreach($videos as $video)

                            @include('videos.includes.video_block', [
                                'video' => $video,
                                'photo_pop' => false
                            ])

                        @endforeach

                    </div>
                </div>

            @endif

            @include('website.layouts.macros.recentalbums', ['n' => 4])

        </div>

    </div>

    <script>
        let mySwiper = new Swiper ('.swiper-container', {
            loop: true,
            slidesPerView: 2,
            spaceBetween: 10,

            autoplay: {
                delay: 2500,
                disableOnInteraction: false,
            },

            scrollbar: {
                el: '.swiper-scrollbar',
                draggable: true,
            },

            breakpoints: {
                1200: {
                    slidesPerView: 5,
                    spaceBetween: 50,
                },
            },
        })
    </script>

@endsection