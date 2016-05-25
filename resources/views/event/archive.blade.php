@extends('website.layouts.default-nobg')

@section('page-title')
    Archive for {{ $year }}
@endsection

@section('content')

    @foreach($months as $key => $month)

        @if($key % 3 == 1)

            <div class="row">

                @endif

                <div class="col-md-4">

                    <div class="panel panel-default">

                        <div class="panel-body">

                            <h3 style="text-align: center;">
                                {{ date('F Y', strtotime($year.'-'.$key.'-25')) }}
                            </h3>

                            <hr>

                            @if(count($month) > 0)

                                <? $week = date('W', $month[0]->start); ?>

                                @foreach($month as $i => $event)

                                    @if($week != date('W', $event->start))
                                        <hr>
                                    @endif

                                    <a class="activity" href="{{ route('event::show', ['id' => $event->id]) }}">
                                        <div class="activity {{ ($i % 2 == 1 ? 'odd' : '') }}">
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

                                    <? $week = date('W', $event->start); ?>

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

@section('stylesheet')

    @parent

    <style>

        a.activity, a.activity:hover, a.activity:active {
            color: #000;
            text-decoration: none;
        }

        div.activity {
            padding: 10px 20px;
            transition: all 0.2s;
        }

        div.activity.odd {
            background-color: rgba(0, 0, 0, 0.04);
        }

        div.activity:hover {
            transform: scale(1.05);
            color: #fff;
            background-color: #333;
        }

        div.activity p {
            margin: 0;
            margin: 5px 0;
        }

        div.activity .fa {
            width: 15px;
            text-align: center;
        }

    </style>

@endsection