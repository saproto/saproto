@extends('website.layouts.default-nobg')

@section('page-title')
    {{ $event->title }}
@endsection

@section('og-description')
    From {{ $event->generateTimespanText('l j F Y, H:i', 'H:i', 'till') }} @ {{ $event->location }}.

    {{ $event->description }}
@endsection

@if($event->image)
@section('og-image'){{ $event->image->generateImagePath(800,300) }}@endsection
@endif

@section('content')

    <div class="row">

        <div class="col-md-{{ (($event->activity && $event->activity->withParticipants()) ? '8' : '8 col-md-offset-2') }}">

            @if($event->image)
                <img src="{{ $event->image->generateImagePath(800,300) }}"
                     style="width: 100%; margin-bottom: 30px; box-shadow: 0 0 20px -7px #000;">
            @endif

            <div class="panel panel-default">

                <div class="panel-heading" style="text-align: center;">

                    @if ($event->secret)
                        [ Hidden! ]
                    @endif

                    From {{ $event->generateTimespanText('l j F Y, H:i', 'H:i', 'till') }}

                    @ {{ $event->location }}

                    @if(Auth::check() && $event->isEventAdmin(Auth::user()))
                        <a href="{{ route("event::admin", ['id'=>$event->id]) }}">
                            <span class="label label-success pull-left">Admin</span>
                        </a>
                    @endif

                    @if(Auth::check() && Auth::user()->can('board'))
                        <a href="{{ route("event::edit", ['id'=>$event->id]) }}">
                            <span class="label label-success pull-right">Edit</span>
                        </a>
                    @endif

                </div>

                <div class="panel-body" id="event-description">

                    {!! Markdown::convertToHtml($event->description) !!}

                    @if($event->committee)
                        <hr>
                        <p>
                            This activity is brought to you by the
                            <a href="{{ route('committee::show', ['id' => $event->committee->getPublicId()]) }}">
                                {{ $event->committee->name }}
                            </a>.
                        </p>
                    @endif

                    @if ($event->involves_food == true)
                        <p>
                            <i>
                                <strong>This activity involves eating food.</strong>
                                If you have any allergies or follow a diet, please make sure to let us know via your
                                <a href="{{ route("user::dashboard") }}#alergies">dashboard</a>.
                            </i>
                        </p>
                    @endif

                    @if ($event->is_external == true)
                        <p>
                            <i>
                                This activity is not organized by S.A. Proto.
                            </i>
                        </p>
                    @endif

                    @if($event->albums->count() > 0)

                        <hr>

                        @foreach($event->albums as $album)

                            <div class="col-md-6 col-xs-6">
                                <a href="{{ route('photo::album::list', ['id' => $album->id]) }}" class="album-link">
                                    <div class="album"
                                         style="background-image: url('{!! $album->thumb !!}')">
                                        <div class="album-name">
                                            {{ $album->name }}
                                        </div>
                                    </div>
                                </a>
                            </div>

                        @endforeach

                    @endif

                </div>

            </div>

            @include('event.display_includes.tickets')

            @if($event->activity && Auth::check() && Auth::user()->member)

                @foreach($event->activity->helpingCommitteeInstances as $key => $instance)

                    @if($key % 2 == 1)

                        <div class="row">

                            @endif

                            <div class="col-md-6">

                                <div class="panel panel-default">

                                    <div class="panel-heading">

                                        {{ $instance->committee->name }}

                                    </div>

                                    <div class="panel-body">

                                        @if ($event->activity->helpingUsers($instance->id)->count() < 1)
                                            <p style="text-align: center;">
                                                No people are currently helping.
                                            </p>
                                        @endif

                                        @foreach($event->activity->helpingUsers($instance->id) as $participation)
                                            <div class="member ellipsis">
                                                <div class="member-picture"
                                                     style="background-image:url('{!! $participation->user->generatePhotoPath(100, 100) !!}');">
                                                </div>
                                                <a href="{{ route("user::profile", ['id'=>$participation->user->getPublicId()]) }}">{{ $participation->user->name }}</a>

                                                @if(Auth::user()->can('board'))
                                                    <p class="pull-right activity__admin-controls">
                                                        <a class="activity__admin-controls__button--delete"
                                                           href="{{ route('event::deleteparticipation', ['participation_id' => $participation->id]) }}">
                                                            <i class="fa fa-times" aria-hidden="true"></i>
                                                        </a>
                                                    </p>
                                                @endif

                                            </div>
                                        @endforeach

                                    </div>

                                    @if($instance->committee->isMember(Auth::user()) || Auth::user()->can('board'))

                                        <div class="panel-footer">

                                            @if($instance->committee->isMember(Auth::user()))

                                                @if($event->activity->getHelpingParticipation($instance->committee, Auth::user()) !== null)
                                                    <a class="btn btn-warning" style="width: 100%;"
                                                       href="{{ route('event::deleteparticipation', ['participation_id' => $event->activity->getHelpingParticipation($instance->committee, Auth::user())->id]) }}">
                                                        I won't help anymore.
                                                    </a>
                                                @elseif($instance->users->count() < $instance->amount)
                                                    <a class="btn btn-success" style="width: 100%;"
                                                       href="{{ route('event::addparticipation', ['id' => $event->id, 'helping_committee_id' => $instance->id]) }}">
                                                        I'll help!
                                                    </a>
                                                @endif

                                            @endif

                                            @if(Auth::user()->can('board'))
                                                <form class="form-horizontal"
                                                      action="{{ route("event::addparticipationfor", ['id' => $event->id, 'helping_committee_id' => $instance->id]) }}"
                                                      method="post">

                                                    {{ csrf_field() }}

                                                    <div class="input-group">
                                                        <input type="text" class="form-control member-name"
                                                               placeholder="John Doe"
                                                               required>
                                                        <input type="hidden" class="member-id" name="user_id" required>
                                                        <span class="input-group-btn">
                                                    <button class="btn btn-danger member-clear" disabled>
                                                        <i class="fa fa-eraser" aria-hidden="true"></i>
                                                    </button>
                                                    <button type="submit" class="btn btn-success">
                                                        <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                                    </button>
                                                </span>
                                                    </div>

                                                </form>
                                            @endif

                                        </div>

                                    @endif

                                </div>

                            </div>

                            @if($key % 2 === 1)

                        </div>

                    @endif

                @endforeach

            @endif

        </div>

        <div class="col-md-4">

            @if($event->activity && Auth::check() && Auth::user()->member && $event->activity->withParticipants())

                <div class="panel panel-default">

                    <div class="panel-heading" style="text-align: center;">
                        <strong>Activity Sign-up</strong>
                        <br>
                        @if($event->activity->canSubscribe())
                            @if($event->activity->participants != -1)
                                {{ ($event->activity->freeSpots() == -1 ? 'unlimited' : $event->activity->freeSpots()) }}
                                out of {{ $event->activity->participants }} places available
                            @else
                                unlimited places available
                            @endif
                        @endif
                    </div>

                    <div class="panel-body" id="event-description">

                        @if ($event->activity->closed)
                            <p style="text-align: center;">
                                This activity is closed and cannot be changed anymore.
                            </p>

                            <hr>
                        @endif

                        <p style="text-align: center;">
                            @if($event->activity->getParticipation(Auth::user()) !== null)
                                @if ($event->activity->getParticipation(Auth::user())->backup)
                                    You are on the <strong>back-up list</strong>.
                                @else
                                    <strong>You are signed up for this activity!</strong>
                                @endif
                            @else
                                You are <strong>not signed up</strong> for this activity.
                            @endif
                        </p>

                        <p>
                            @if($event->activity->getParticipation(Auth::user()) !== null)
                                @if($event->activity->canUnsubscribe() || $event->activity->getParticipation(Auth::user())->backup)
                                    <a class="btn btn-warning" style="width: 100%;"
                                       href="{{ route('event::deleteparticipation', ['participation_id' => $event->activity->getParticipation(Auth::user())->id]) }}">
                                        @if ($event->activity->getParticipation(Auth::user())->backup)
                                            Sign me out of the back-up list.
                                        @else
                                            Sign me out. <i class="fa fa-frown-o" aria-hidden="true"></i>
                                        @endif
                                    </a>
                                @endif
                            @else
                                @if($event->activity->canSubscribeBackup())
                                    <a class="btn btn-{{ ($event->activity->isFull() || !$event->activity->canSubscribe() ? 'warning' : 'success') }}"
                                       style="width: 100%;"
                                       href="{{ route('event::addparticipation', ['id' => $event->id]) }}">
                                        @if ($event->activity->isFull() || !$event->activity->canSubscribe())
                                            {{ ($event->activity->isFull() ? 'Full!' : 'Closed!') }}
                                            Put me on the back-up list.
                                        @else
                                            Sign me up!
                                        @endif

                                        <span class="badge">
                                            @if ($event->activity->price > 0)
                                            &euro;{{ number_format($event->activity->price, 2, '.', ',') }}
                                            @else
                                                free
                                            @endif
                                        </span>
                                    </a>
                                @endif
                            @endif
                        </p>

                        @if ($event->activity->no_show_fee > 0)
                            <p>
                            <div class="btn btn-warning" data-toggle="modal" data-target="#noshow-modal"
                                 style="text-align: center; width: 100%;">

                                Not showing up can cost you
                                &euro;{{ number_format($event->activity->no_show_fee + $event->activity->price, 2, '.', ',') }}

                                &nbsp;&nbsp;&nbsp;
                                <span class="badge" style="cursor: pointer;">
                                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                                </span>

                            </div>
                            </p>
                        @endif

                        <hr>

                        <p style="text-align: center;">
                            <strong>Participation:</strong>
                            &euro;{{ number_format($event->activity->price, 2, '.', ',') }}
                            <br>
                            <strong>Sign up opens:</strong> {{ date('F j, H:i', $event->activity->registration_start) }}
                            <br>
                            <strong>Sign up closes:</strong> {{ date('F j, H:i', $event->activity->registration_end) }}
                            <br>
                            <strong>Sign out possible
                                until:</strong> {{ date('F j, H:i', $event->activity->deregistration_end) }}
                        </p>

                        @if($event->activity->users->count() > 0)

                            <hr>

                            <p style="text-align: center; padding-bottom: 5px;">
                                {{ $event->activity->users->count() }} participants:
                            </p>
                        @endif

                        @foreach($event->activity->users as $user)

                            <div class="member ellipsis">
                                <div class="member-picture"
                                     style="background-image:url('{!! $user->generatePhotoPath(100, 100) !!}');"></div>
                                <a href="{{ route("user::profile", ['id'=>$user->getPublicId()]) }}">{{ $user->name }}</a>

                                @if(Auth::user()->can('board') && !$event->activity->closed)
                                    <p class="pull-right activity__admin-controls">
                                        <a class="activity__admin-controls__button--delete"
                                           href="{{ route('event::deleteparticipation', ['participation_id' => $user->pivot->id]) }}">
                                            <i class="fa fa-times" aria-hidden="true"></i>
                                        </a>
                                    </p>
                                @endif
                            </div>

                        @endforeach

                        @if ($event->activity->backupUsers->count() > 0)

                            <hr>

                            <p style="text-align: center; padding-bottom: 5px;">
                                {{ $event->activity->backupUsers->count() }} people on back-up list:
                            </p>

                            @foreach($event->activity->backupUsers as $user)

                                <div class="member ellipsis">
                                    <div class="member-picture"
                                         style="background-image:url('{!! $user->generatePhotoPath(100, 100) !!}');"></div>
                                    <a href="{{ route("user::profile", ['id'=>$user->getPublicId()]) }}">{{ $user->name }}</a>

                                    @if(Auth::user()->can('board'))
                                        <p class="pull-right activity__admin-controls">
                                            <a class="activity__admin-controls__button--delete"
                                               href="{{ route('event::deleteparticipation', ['participation_id' => $user->pivot->id]) }}">
                                                <i class="fa fa-times" aria-hidden="true"></i>
                                            </a>
                                        </p>
                                    @endif
                                </div>

                            @endforeach

                        @endif

                    </div>

                    @if(Auth::user()->can('board'))

                        <div class="panel-footer clearfix">
                            <div class="form-group">
                                <div id="user-select">
                                    <form class="form-horizontal"
                                          action="{{ route("event::addparticipationfor", ['id' => $event->id]) }}"
                                          method="post">

                                        {{ csrf_field() }}

                                        <div class="input-group">
                                            <input type="text" class="form-control member-name"
                                                   placeholder="John Doe"
                                                   required>
                                            <input type="hidden" class="member-id" name="user_id" required>
                                            <span class="input-group-btn">
                                                    <button class="btn btn-danger member-clear" disabled>
                                                        <i class="fa fa-eraser" aria-hidden="true"></i>
                                                    </button>
                                                    <button type="submit" class="btn btn-success">
                                                        <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                                    </button>
                                                </span>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>

                    @endif

                </div>

            @elseif($event->activity && $event->activity->withParticipants())

                <div class="panel panel-default">

                    <div class="panel-heading">
                        Activity Sign-up
                    </div>

                    <div class="panel-body" style="text-align: center;">
                        <p>This activity requires you to sign-up. You can only sign-up when you are a member.</p>
                        @if(!Auth::check()) <p>Please <a href="{{ route('login::show') }}">log-in</a> if you are already
                            a member.</p> @endif
                        @if(Auth::check() && !Auth::user()->member) <p>Please <a href="{{ route('becomeamember') }}">become
                                a member</a> to sign-up for this activity.</p> @endif
                    </div>

                </div>

            @endif

        </div>

    </div>

    <div id="noshow-modal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">No show fee</h4>
                </div>
                <div class="modal-body">

                    <p>
                        For some activities Proto, or another party, sponsors part of the participation fee or other
                        costs associated with an activity. As an example, for a barbecue a sponsor may pay for the food.
                    </p>

                    <p>
                        For these kinds of activities a <i>no show fee</i> may be enacted, which compensates for the
                        fact that money has been spent for people who do not show up. This means that if you sign up,
                        but don't show up for the activity, the <i>no show fee</i> may be charged to you. This may even
                        be the case for free activities.
                    </p>

                </div>
            </div>
        </div>
    </div>

@endsection

@section('javascript')

    @parent

    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>

    <script>

        $(".member-name").each(function () {
            $(this).autocomplete({
                minLength: 3,
                source: "{{ route("api::members") }}",
                select: function (event, ui) {
                    $(this).val(ui.item.name + " (ID: " + ui.item.id + ")").prop('disabled', true);
                    $(this).next(".member-id").val(ui.item.id);
                    $(this).parent().find(".member-clear").prop('disabled', false);
                    return false;
                }
            }).autocomplete("instance")._renderItem = function (ul, item) {
                console.log(ul);
                return $("<li>").append(item.name).appendTo(ul);
            };
        });

        $(".member-clear").each(function () {
            $(this).click(function (e) {
                e.preventDefault();
                $(this).parent().parent().find(".member-name").val("").prop('disabled', false);
                $(this).prop('disabled', true);
                $("#member-id").val("");
            });
        });

    </script>

@endsection

@section('stylesheet')

    @parent

    <style>

        #event-description {
            text-align: justify;
        }

    </style>

@endsection
