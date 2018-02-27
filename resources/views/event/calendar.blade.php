@extends('website.layouts.default-nobg')

@section('page-title')
    Calendar
@endsection

@section('content')

    <div class="row">

        <div class="col-md-12">

            <div class="panel panel-default">

                <div class="panel-body">

                    <span style="font-weight: 700; margin: 0 15px;">Archive</span>

                    @foreach($years as $year)

                        <span style="padding: 5px 15px; background-color: rgba(0,0,0,0.05); margin-right: 15px;">
                        <a href="{{ route('event::archive', ['year'=>$year]) }}" style="text-decoration: none;">
                            {{ $year }}
                        </a>
                        </span>

                    @endforeach
                </div>

            </div>

        </div>

    </div>

    <div class="row calendar">

        @foreach($events as $key => $section)

            <div class="col-md-4">

                @if($key == 1)

                    <div class="panel panel-default">

                        <div class="panel-body">

                            <div class="btn-group btn-lg btn-group-justified">
                                <div class="btn btn-info" data-toggle="modal" data-target="#calendar-modal">
                                    <i class="fa fa-calendar-plus-o" aria-hidden="true"></i>
                                    &nbsp;&nbsp;&nbsp;
                                    Add to your Calendar
                                </div>
                            </div>

                        </div>

                    </div>

                @endif

                <div class="panel panel-default">

                    <div class="panel-body">

                        <h3 style="text-align: center;">
                            @if($key == 0)
                                Soon
                            @elseif($key == 1)
                                This month
                            @elseif($key == 2)
                                Later
                            @endif
                        </h3>

                        <hr>

                        @if(count($section) > 0)

                            <?php $week = date('W', $section[0]->start); ?>

                            @foreach($section as $key => $event)

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

                        @else
                            <p style="font-style: italic; text-align: center;">
                                No activities to show...
                            </p>
                        @endif

                    </div>

                </div>

            </div>

        @endforeach

    </div>

    <!-- Modal for deleting automatic withdrawal. //-->
    <div id="calendar-modal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Import our calendar into yours!</h4>
                </div>
                <div class="modal-body">

                    <p>
                        If you want to, you can import our calendar into yours. This can be easily done by going to your
                        favorite calendar application and looking for an option similar to <i>Import calendar by URL</i>.
                        You can then to copy the URL below.
                    </p>
                    <p>
                        <input class="form-control" onclick="this.select()" value="{{ $ical_url }}">
                    </p>

                    <hr>

                    <a class="btn btn-info" type="button" style="width: 100%;" target="_blank"
                       href="https://calendar.google.com/calendar/r?cid={{ urlencode(str_replace("https://", "http://", $ical_url)) }}">
                        <i class="fa fa-google" aria-hidden="true"></i>
                        &nbsp;&nbsp;&nbsp;Add to Google Calendar
                    </a>

                    @if(Auth::check())

                        <hr>

                        <p style="text-align: center;">
                            @if ($relevant_only)
                                <strong>Your are currently only syncing relevant events.</strong>
                            @else
                                You are currently syncing all events.
                            @endif

                            <a class="btn btn-{{ $relevant_only ? 'success':'danger' }}" type="button"
                               style="width: 100%;" href="{{ route('event::toggle_relevant_only') }}">
                                @if ($relevant_only)
                                    Sync all my events.
                                @else
                                    Sync only relevant events.
                                @endif
                            </a>

                            <sub>
                                Relevant events are events you either attend, organize or help with.
                            </sub>

                        </p>

                        <hr>

                        <p style="text-align: center;">
                            <sub>
                                @if ($reminder)
                                    You are currently recieving a reminder {{ $reminder }} hours before an
                                    activity you participate in.
                                @else
                                    You are currently <strong>not</strong> receiving a reminder before an activity you
                                    participate in.
                                @endif
                            </sub>
                        </p>

                        <form method="post"
                              action="{{ route('event::set_reminder') }}">

                            {!! csrf_field() !!}

                            <div class="row">

                                <div class="{{ $reminder ? 'col-md-4' : 'col-md-4 col-md-offset-2' }}">
                                    <div class="input-group">
                                        <input class="form-control" type="number" step="0.01" placeholder="0.5"
                                               name="hours" value="{{ $reminder ? $reminder : '' }}">
                                        <div class="input-group-addon">hours</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <button class="btn btn-success" type="submit" name="save" style="width: 100%;">
                                        Set reminder.
                                    </button>
                                </div>
                                @if ($reminder)
                                    <div class="col-md-4">
                                        <button class="btn btn-danger" type="submit" name="delete" style="width: 100%;">
                                            Remove reminder.
                                        </button>
                                    </div>
                                @endif

                            </div>

                        </form>

                        <p style="text-align: center;">
                            <sub>
                                Reminders are not supported in Google Calendar. Blame Google. 😟
                            </sub>
                        </p>

                    @endif

                </div>
            </div>
        </div>
    </div>

@endsection
