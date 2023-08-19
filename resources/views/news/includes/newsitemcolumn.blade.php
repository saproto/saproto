<div class="card mb-3">

    <div class="card-header">
        <i class="fas fa-newspaper"></i> {{$text}}
    </div>

    <div class="card-body">

        <div class="row">

            @if(count($items) == 0)
                <div class="text-center">
                    <br>
                    <strong>
                        There are currently no {{$text}}.
                    </strong>
                </div>
            @else

                @foreach($items as $index => $newsitem)

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

            @endif

        </div>

    </div>

</div>