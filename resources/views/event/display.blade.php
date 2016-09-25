@extends('website.layouts.default-nobg')

@section('page-title')
    {{ $event->title }}
@endsection

@section('content')

    <div class="row">

        <div class="col-md-{{ ($event->activity && Auth::check() && Auth::user()->member ? '8' : '8 col-md-offset-2') }}">

            @if($event->image)
                <img src="{{ $event->image->generateImagePath(800,300) }}"
                     style="width: 100%; margin-bottom: 30px; box-shadow: 0 0 20px -7px #000;">
            @endif

            <div class="panel panel-default">

                <div class="panel-heading" style="text-align: center;">

                    @if ($event->secret)
                        [ Hidden! ]
                    @endif

                    From {{ date('l j F Y, H:i', $event->start) }} till

                    @if (($event->end - $event->start) < 3600 * 24)
                        {{ date('H:i', $event->end) }}
                    @else
                        {{ date('l j F, H:i', $event->end) }}
                    @endif

                    @ {{ $event->location }}

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

                        This activity is brought to you by the
                        <a href="{{ route('committee::show', ['id' => $event->committee->id]) }}">
                            {{ $event->committee->name }}
                        </a>.

                    @endif

                </div>

            </div>

            @if($event->activity && Auth::check() && Auth::user()->member)

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

                                        @if ($event->activity->helpingUsers($committee->pivot->id)->count() < 1)
                                            <p style="text-align: center;">
                                                No people are currently helping.
                                            </p>
                                        @endif

                                        @foreach($event->activity->helpingUsers($committee->pivot->id) as $participation)
                                            <div class="member">
                                                <div class="member-picture"
                                                     style="background-image:url('{!! ($participation->user->photo ? $participation->user->photo->generateImagePath(100, 100) : '') !!}');">
                                                </div>
                                                <a href="{{ route("user::profile", ['id'=>$participation->user->id]) }}">{{ $participation->user->name }}</a>

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

                                    @if($committee->isMember(Auth::user()))

                                        <div class="panel-footer">

                                            @if($event->activity->getHelpingParticipation($committee, Auth::user()) !== null)
                                                <a class="btn btn-warning" style="width: 100%;"
                                                   href="{{ route('event::deleteparticipation', ['participation_id' => $event->activity->getHelpingParticipation($committee, Auth::user())->id]) }}">
                                                    I won't help anymore.
                                                </a>
                                            @else
                                                <a class="btn btn-success" style="width: 100%;"
                                                   href="{{ route('event::addparticipation', ['id' => $event->id, 'helping_committee_id' => $committee->pivot->id]) }}">
                                                    I'll help!
                                                </a>
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

        @if($event->activity && Auth::check() && Auth::user()->member)

            <div class="col-md-4">

                <div class="panel panel-default">

                    <div class="panel-heading" style="text-align: center;">
                        Activity Sign-up
                        @if($event->activity->canSubscribe())
                            ({{ $event->activity->freeSpots() }} places available)
                        @endif
                    </div>

                    <div class="panel-body" id="event-description">

                        @if ($event->activity->closed)
                            <p style="text-align: center;">
                                This activity is closed and cannot be changed anymore.
                            </p>
                        @endif

                        <p style="text-align: center;">
                            @if($event->activity->getParticipation(Auth::user()) !== null)
                                @if ($event->activity->getParticipation(Auth::user())->backup)
                                    You are on the <strong>back-up list</strong>.
                                @else
                                    <strong>You are signed up for this activity!</strong>
                                @endif
                            @else
                                You are <strong>not signed</strong> up for this activity.
                            @endif
                        </p>

                        <p>
                            @if($event->activity->getParticipation(Auth::user()) !== null)
                                @if($event->activity->canUnsubscribe())
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
                                @if($event->activity->canSubscribe())
                                    <a class="btn btn-{{ ($event->activity->isFull() ? 'warning' : 'success') }}"
                                       style="width: 100%;"
                                       href="{{ route('event::addparticipation', ['id' => $event->id]) }}">
                                        @if ($event->activity->isFull())
                                            Activity is full. Sign me up for the back-up list.
                                        @else
                                            Sign me up!
                                        @endif
                                    </a>
                                @endif
                            @endif
                        </p>

                        <p style="text-align: center;">
                            Sign up is possible between {{ date('F j, H:i', $event->activity->registration_start) }}
                            and {{ date('F j, H:i', $event->activity->registration_end) }}. You can sign out
                            untill {{ date('F j, H:i', $event->activity->deregistration_end) }}.
                        </p>

                        <hr>

                        @foreach($event->activity->users as $user)

                            <div class="member">
                                <div class="member-picture"
                                     style="background-image:url('{!! ($user->photo ? $user->photo->generateImagePath(100, 100) : '') !!}');"></div>
                                <a href="{{ route("user::profile", ['id'=>$user->id]) }}">{{ $user->name }}</a>

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

                            <p style="text-align: center;">
                                Back-up list:
                            </p>

                            @foreach($event->activity->backupUsers as $user)

                                <div class="member">
                                    <div class="member-picture"
                                         style="background-image:url('{!! ($user->photo ? $user->photo->generateImagePath(100, 100) : '') !!}');"></div>
                                    <a href="{{ route("user::profile", ['id'=>$user->id]) }}">{{ $user->name }}</a>

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

                </div>


            @if(Auth::user()->can('board'))

                <div class="panel panel-default">

                    <div class="panel-heading">
                        Contact details participants
                    </div>

                    <div class="panel-body">
                        <p>Please remember to always use the BCC field (not the to or CC field) when sending emails to participants!</p>
                        <textarea class="form-control">@foreach($event->activity->users as $user){{ $user->email }},@endforeach</textarea>
                    </div>

                </div>

            @endif

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