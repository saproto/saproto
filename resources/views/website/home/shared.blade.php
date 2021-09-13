@extends('website.layouts.redesign.generic')

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
                        @if (Auth::check() && Auth::user()->is_member && $header->user->member)
                            Photo by <a href="{{ route('user::profile', ['id' => $header->user->getPublicId()]) }}"
                                        class="text-white">
                                {{ $header->user->name }}</a>
                        @else
                            Photo by {{ $header->user->name }}
                        @endif
                    </small>
                @endif
                <div class="card-body" style="text-align: left; vertical-align: bottom; font-size: 30px; display: flex;">
                    <p class="card-text ellipsis px-1" style="align-self: flex-end;">
                        @section('greeting')
                        @show
                    </p>
                </div>
            </div>

            @if(count($companies) > 0)

                <div class="card mb-3">
                    <div class="card-body pb-0 pt-1 position-relative">
                        <div class="row mb-1 swiper" style="height:70px">
                            <div class="swiper-wrapper">
                                @foreach($companies as $i => $company)
                                    @if($company->image)
                                        <div class="swiper-slide justify-content-center align-items-center d-flex">
                                            <a href="{{ route('companies::show', ['id' => $company->id]) }}">
                                                <img class="company-{{strtolower($company->name)}}"
                                                     src="{{ $company->image->generateImagePath(null, 50) }}"/>
                                            </a>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

            @endif

            @section('left-column')
            @show

        </div>

        <div class="col-xl-3 col-md-6 col-sm-12">
            @section('right-column')

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

            @show

        </div>

    </div>

@endsection
