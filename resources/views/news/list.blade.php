@extends('website.layouts.redesign.generic-sidebar')

@section('page-title')
    News
@endsection

@section('container')

    <div class="card mb-3">

        <div class="card-header bg-dark text-white text-center">
            All news
        </div>

        <div class="card-body">

            <div class="row">

                @if(count($newsitems) == 0)

                    <div class="row">

                        <div class="col-md-4 col-md-offset-4">
                            <div class="panel panel-default news__card">
                                <div class="panel-body">
                                    <p>
                                        &nbsp;
                                    </p>
                                    <p style="text-align: center">
                                        <strong>
                                            There are currently no news articles.
                                        </strong>
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>

                @else

                    @foreach($newsitems as $index => $newsitem)

                        <div class="col-md-4 col-sm-6">

                            @include('website.layouts.macros.card-bg-image', [
                                        'url' => $newsitem->url(),
                                        'img' => $newsitem->featuredImage ? $newsitem->featuredImage->generateImagePath(300,200) : null,
                                        'html' => sprintf('<strong>%s</strong><br>Published %s', $newsitem->title, Carbon::parse($newsitem->published_at)->diffForHumans()),
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
