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

            @include('website.home.news')

            @if(count($newsitems) <= 2)
                @include('website.home.recentphotos')
            @endif

        </div>

        <div class="col-md-4">

            @if (count($birthdays) > 0)


                <div class="panel panel-default homepage__calendar">

                    <div class="panel-body calendar">

                        <h4 style="text-align: center;">
                            Today's birthdays
                        </h4>

                        <hr>

                        @foreach($birthdays as $key => $user)

                            <div class="member ellipsis">
                                <div class="member-picture"
                                     style="background-image:url('{!! $user->generatePhotoPath(100, 100) !!}');">
                                </div>
                                <a href="{{ route("user::profile", ['id'=>$user->getPublicId()]) }}">{{ $user->name }}</a>
                            </div>

                        @endforeach

                    </div>

                </div>

            @endif


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
                           href="{{ route('event::show', ['id' => $event->getPublicId()]) }}">
                            <div class="activity {{ ($key % 2 == 1 ? 'odd' : '') }}" {!! ($event->secret ? 'style="opacity: 0.3;"' : '') !!}>
                                <p><strong>{{ $event->title }}</strong></p>
                                <p><i class="fa fa-map-marker" aria-hidden="true"></i> {{ $event->location }}
                                </p>
                                <p>
                                    <i class="fa fa-clock-o" aria-hidden="true"></i>
                                    {{ $event->generateTimespanText('l j F, H:i', 'H:i', '-') }}
                                </p>
                                @if($event->is_external)
                                    <p>
                                        <i class="fa fa-info-circle" aria-hidden="true"></i> Not Organized
                                        by S.A. Proto
                                    </p>
                                @endif
                            </div>
                        </a>

                        <?php $week = date('W', $event->start); ?>

                    @endforeach

                    <hr>

                    <a class="btn btn-success" style="width: 100%;" href="{{ route('event::list') }}">More upcoming
                        events</a>

                </div>

            </div>

        </div>

        @if(count($newsitems) > 2)
            @include('website.home.recentphotos')
        @endif

    </div>

@endsection
