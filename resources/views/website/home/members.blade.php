@extends('website.home.shared')

@section('greeting')

    <h1>
        <strong>Hi, {{ Auth::user()->calling_name }}</strong>
    </h1>
    <h3>
        @if($message != null) {{ $message->message }} @else Nice to see you back! @endif
    </h3>

@endsection

@section('visitor-specific')
    <div class="row">
        <div class="col-md-8">

            <div class="panel panel-default">

                <div class="panel-body" style="padding: 1.8rem;">

                    <p>
                        Welcome to the new Proto website. You should find most of what you had on the old website around
                        here somewhere, and the final missing features are coming soon. Should you miss something, do let us
                        know!
                    </p>

                    <h3>Recent News Articles</h3>

                    @if(count($newsitems) == 0)
                        <p>
                            &nbsp;
                        </p>
                        <p style="text-align: center">
                            <strong>
                                There are currently no news articles.
                            </strong>
                        </p>
                    @endif

                    @foreach($newsitems as $index => $newsitem)
                        @if($index > 0)
                        <hr class="rule">
                        @endif

                        <div class="media">
                          @if ($newsitem->featuredImage)
                          <div class="media-left">
                            <img src="{{ $newsitem->featuredImage->generateImagePath(192,192) }}" width="96" height="96" alt="">
                          </div>
                          @endif
                          <div class="media-body">
                            <h5 class="media-heading"><a href=" href="{{ $newsitem->url() }}"">{{ $newsitem->title }}</a></h5>
                            <em class="small-text">
                                Published {{ Carbon::parse($newsitem->published_at)->diffForHumans() }}
                            </em>
                            <p class="medium-text">{{ $newsitem->content }}</p>
                          </div>
                        </div>
                    @endforeach
                </div>

            </div>

        </div>
        <div class="col-md-4">

            <div class="panel panel-default homepage__calendar">

                <div class="panel-body calendar">

                    <h4 style="text-align: center;">
                        Upcoming activities
                    </h4>

                    <hr>

                    <?php if (isset($events[0])) $week = date('W', $events[0]->start); ?>

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
                                    {{ $event->generateTimespanText('l j F, H:i', 'H:i', '-') }}
                                </p>
                            </div>
                        </a>

                        <?php $week = date('W', $event->start); ?>

                    @endforeach

                    <hr>

                    <a class="btn btn-success" style="width: 100%;" href="{{ route('event::list') }}">More upcoming events</a>

                </div>
            </div>
        </div>
    </div>

@endsection
