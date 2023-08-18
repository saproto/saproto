@extends('website.layouts.redesign.generic')

@section('page-title')
    News
@endsection

@section('container')

    <div class="card mb-3">

        <div class="card-body">

            <div class="row">

                @can('board')
                    <a href="{{route("news::admin")}}" class="btn btn-info">
                        <i class="fas fa-edit"></i> <span class="d-none d-sm-inline">News admin</span>
                    </a>
                @endcan

                @if(count($newsitems) + count($weeklies) == 0)
                    <div class="text-center">
                        <br>
                        <strong>
                            There are currently no news articles.
                        </strong>
                    </div>
                @else

                    @foreach($newsitems as $index => $newsitem)

                        <div class="col-md-4 col-sm-6">

                            @include('website.home.cards.card-bg-image', [
                                        'url' => $newsitem->url,
                                        'img' => $newsitem->featuredImage ? $newsitem->featuredImage->generateImagePath(500,300) : null,
                                        'html' => sprintf('<strong>%s</strong><br>Published %s', $newsitem->title, Carbon::parse($newsitem->published_at)->diffForHumans()),
                                        'height' => '180',
                                        'photo_pop' => true
                            ])

                        </div>

                    @endforeach

                        @foreach($weeklies as $index => $weekly)

                            <div class="col-md-4 col-sm-6">

                                @include('website.home.cards.card-bg-image', [
                                            'url' => $weekly->url,
                                            'img' => $weekly->featuredImage ? $weekly->featuredImage->generateImagePath(500,300) : null,
                                            'html' => sprintf('<strong>%s</strong><br>Published %s', $weekly->title, Carbon::parse($weekly->published_at)->diffForHumans()),
                                            'height' => '180',
                                            'photo_pop' => true
                                ])

                            </div>

                        @endforeach

                @endif

            </div>

        </div>

    </div>

@endsection
