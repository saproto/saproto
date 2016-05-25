@extends('website.layouts.default-nobg')

@section('page-title')
    {{ $event->title }}
@endsection

@section('content')

    <div class="row">

        <div class="col-md-{{ ($event->activity && $event->activity->participants ? '8' : '8 col-md-offset-2') }}">

            <div class="panel panel-default">

                <div class="panel-heading" style="text-align: center;">

                    From {{ date('l j F, H:i', $event->start) }} till

                    @if (($event->end - $event->start) < 3600 * 24)
                        {{ date('H:i', $event->end) }}
                    @else
                        {{ date('l j F, H:i', $event->end) }}
                    @endif

                    @ {{ $event->location }}

                </div>

                <div class="panel-body" id="event-description">

                    {!! $event->description !!}

                </div>

            </div>

            @if($event->activity)

                @foreach($event->activity->helpingCommittees as $key => $committee)

                    @if($key % 2 == 1)

                        <div class="row">

                            @endif

                            <div class="col-md-6">

                                <div class="panel panel-default">

                                    <div class="panel-heading">
                                        {{ $committee->name }}
                                    </div>

                                    <div class="panel-body">

                                        @foreach($event->activity->helpingUsers($committee->id) as $user)

                                        @endforeach

                                    </div>

                                </div>

                            </div>

                            @if($key % 2 === 1)

                        </div>

                    @endif

                @endforeach

            @endif

        </div>

        @if($event->activity && $event->activity->participants)

            <div class="col-md-4">

                <div class="panel panel-default">

                    <div class="panel-heading" style="text-align: center;">
                        Sign-up
                    </div>

                    <div class="panel-body" id="event-description">
                        @if (date('U') > $event->activity->registration_start && date('U') < $event->activity->registration_start)
                            <p style="text-align: center;">
                                Open between {{ date('M d, H:i', $event->activity->registration_start) }}
                                and {{ date('M d, H:i', $event->activity->registration_end) }}.
                            </p>
                        @else
                            <p style="text-align: center;">
                                Sign-up closes {{ date('M d, H:i', $event->activity->registration_end) }}.
                            </p>
                        @endif
                        <hr>
                        @foreach($event->activity->users as $user)
                            <p>{{ $user->name }}</p>
                        @endforeach
                    </div>

                </div>

            </div>

        @endif

    </div>

@endsection

@section('stylesheet')

    @parent

    <style>

        #event-description {
            text-align: justify;
        }

    </style>

@endsection