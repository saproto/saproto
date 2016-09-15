@extends('website.layouts.default-nobg')

@section('page-title')
    Archive for {{ $year }}
@endsection

@section('content')

    <div class="row">

        <div class="col-md-12">

            <div class="panel panel-default">

                <div class="panel-body">

                    <span style="font-weight: 700; margin: 0 15px;">Archive</span>

                    @foreach($years as $y)

                        <span style="padding: 5px 15px; background-color: rgba(0,0,0,0.05); margin-right: 15px;">
                        <a href="{{ route('event::archive', ['year'=>$y]) }}" style="text-decoration: none;">
                            {{ $y }}
                        </a>
                        </span>

                    @endforeach

                </div>

            </div>

        </div>

    </div>

    @foreach($months as $key => $month)

        @if($key % 3 == 1)

            <div class="row calendar">

                @endif

                <div class="col-md-4">

                    <div class="panel panel-default">

                        <div class="panel-body">

                            <h3 style="text-align: center;">
                                {{ date('F Y', strtotime($year.'-'.$key.'-25')) }}
                            </h3>

                            <hr>

                            @if(count($month) > 0)

                                <?php$week = date('W', $month[0]->start); ?>

                                @foreach($month as $i => $event)

                                    @if($week != date('W', $event->start))
                                        <hr>
                                    @endif

                                    <a class="activity" href="{{ route('event::show', ['id' => $event->id]) }}">
                                        <div class="activity {{ ($i % 2 == 1 ? 'odd' : '') }}" {!! ($event->secret ? 'style="opacity: 0.3;"' : '') !!}>
                                            <p><strong>{{ $event->title }}</strong></p>
                                            <p><i class="fa fa-map-marker"
                                                  aria-hidden="true"></i> {{ $event->location }}
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

                                    <?php$week = date('W', $event->start); ?>

                                @endforeach

                            @else
                                <p style="font-style: italic; text-align: center;">
                                    No activities to show...
                                </p>
                            @endif

                        </div>

                    </div>

                </div>

                @if($key % 3 === 0)

            </div>

        @endif

    @endforeach

@endsection