<div class="row">

    <div id="archive-bar" class="col text-center">

        <div class="btn-group mb-3">

            <a href="{{ route("event::list") }}"
               class="btn btn-{{ Route::currentRouteName() == 'event::list' ? 'primary' : 'light' }}">
                Upcoming
            </a>

            <button class="btn btn-{{ Route::currentRouteName() == 'event::sorted' ? 'primary' : 'secondary' }} d-none d-lg-block" type="button" id="sorted-dropdown-button" data-toggle="dropdown">
                Sorted
            </button>
            <button class="btn btn-{{ Route::currentRouteName() == 'event::sorted' ? 'primary' : 'secondary' }} d-block d-lg-none" type="button" id="sorted-modal-button" data-toggle="modal" data-target="#category-modal">
                Sorted
            </button>
            <div class="dropdown-menu" style="z-index: 10" aria-labelledby=sorted-dropdown-button>
                @foreach(config('event.category') as $category=>$index)
                    <a class="dropdown-item" href="{{ route("event::sorted", ['category'=>$index]) }}">{{ $category }}</a>
                @endforeach
            </div>

            <button type="button" class="btn btn-secondary" disabled>
                Archive
            </button>

            @foreach($years as $y)

                @if(Event::countEventsPerYear($y) > 0)

                    <a href="{{ route('event::archive', ['year'=>$y]) }}"
                       class="btn btn-{{ Route::currentRouteName() == 'event::archive' && $y == $year ? 'primary' : 'light' }}">
                        {{ $y }}
                    </a>

                @endif

            @endforeach

            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#calendar-modal">
                <i class="fas fa-calendar-alt mr-2 d-inline"></i> <span class="d-none d-xl-inline">Import calendar</span>
            </button>

            @if(Auth::check() && Auth::user()->can('board'))
                <a href="{{ route("event::add") }}" class="btn btn-info">
                    <i class="fas fa-calendar-plus mr-2 d-inline"></i> <span class="d-none d-xl-inline">Create event</span>
                </a>
            @endif

        </div>

    </div>

</div>

<div id="category-modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Select a category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
            </div>
            <div class="modal-body">
                <ul class="nav flex-column">
                @foreach(config('event.category') as $category=>$index)
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route("event::sorted", ['category'=>$index]) }}">{{ $category }}</a>
                    </li>
                @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>

<div id="calendar-modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Import our calendar into yours!</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">

                <p>
                    If you want to, you can import our calendar into yours. This can be easily done by going to your
                    favorite calendar application and looking for an option similar to <i>Import calendar by URL</i>.
                    You can then to copy the URL below.
                </p>
                <p>
                    <input class="form-control" onclick="this.select()"
                           value="{{ Auth::check() ? Auth::user()->getIcalUrl() : route("ical::calendar") }}">
                </p>

                <hr>

                <a class="btn btn-info" type="button" style="width: 100%;" target="_blank"
                   href="https://calendar.google.com/calendar/r?cid={{ urlencode(str_replace("https://", "http://", Auth::check() ? Auth::user()->getIcalUrl() : route("ical::calendar"))) }}">
                    <i class="fas fa-google" aria-hidden="true"></i>
                    &nbsp;&nbsp;&nbsp;Add to Google Calendar
                </a>

                @if(Auth::check())

                    <hr>

                    <p style="text-align: center;">
                        @if (Auth::user()->getCalendarRelevantSetting())
                            <strong>Your are currently only syncing relevant events.</strong>
                        @else
                            You are currently syncing all events.
                        @endif

                        <a class="btn btn-{{ Auth::check() && Auth::user()->getCalendarRelevantSetting() ? 'success':'danger' }}"
                           type="button"
                           style="width: 100%;" href="{{ route('event::toggle_relevant_only') }}">
                            @if (Auth::user()->getCalendarRelevantSetting())
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
                            @if (Auth::user()->getCalendarAlarm())
                                You are currently recieving a reminder {{ Auth::user()->getCalendarAlarm() }} hours
                                before an
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

                            <div class="{{ Auth::user()->getCalendarAlarm() ? 'col-md-4' : 'col-md-4 col-md-offset-2' }}">
                                <div class="input-group">
                                    <input class="form-control" type="number" step="0.01" placeholder="0.5"
                                           name="hours"
                                           value="{{ Auth::user()->getCalendarAlarm() ? Auth::user()->getCalendarAlarm() : '' }}">
                                    <div class="input-group-addon">hours</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <button class="btn btn-success" type="submit" name="save" style="width: 100%;">
                                    Set reminder.
                                </button>
                            </div>
                            @if (Auth::user()->getCalendarAlarm())
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
