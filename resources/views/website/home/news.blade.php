@if(count($newsitems) > 0)

    <div class="panel panel-default">

        <div class="panel-body" style="padding: 1.8rem;">

            <h3>Recent News Articles</h3>

            @foreach($newsitems as $index => $newsitem)
                @if($index > 0)
                    <hr class="rule">
                @endif

                <div class="media">
                    @if ($newsitem->featuredImage)
                        <div class="media-left">
                            <img src="{{ $newsitem->featuredImage->generateImagePath(192,192) }}" width="96"
                                 height="96" alt="">
                        </div>
                    @endif
                    <div class="media-body">
                        <h5 class="media-heading"><a href="{{ $newsitem->url() }}">{{ $newsitem->title }}</a>
                        </h5>
                        <em class="small-text">
                            Published {{ Carbon::parse($newsitem->published_at)->diffForHumans() }}
                        </em>
                        <p class="medium-text">{!!  Markdown::convertToHtml(\Illuminate\Support\Str::words($newsitem->content, 50)) !!} </p>
                    </div>
                </div>
            @endforeach
        </div>

    </div>

@endif