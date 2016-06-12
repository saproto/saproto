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

                    <a href="{{ route("event::edit", ['id'=>$event->id]) }}">
                        <span class="label label-success pull-right">Edit</span>
                    </a>

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

                                        @foreach($event->activity->helpingUsers($committee->pivot->id) as $participation)
                                            <div class="member">
                                                <div class="member-picture"
                                                     style="background-image:url('{{ route("file::get", ['id' => $participation->user->photo]) }}');">
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

        @if($event->activity && $event->activity->participants)

            <div class="col-md-4">

                <div class="panel panel-default">

                    <div class="panel-heading" style="text-align: center;">
                        Activity Sign-up
                        @if($event->activity->canSubscribe())
                            ({{ $event->activity->freeSpots() }} places available)
                        @endif
                    </div>

                    <div class="panel-body" id="event-description">

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

                        @foreach($event->activity->users() as $user)

                            <div class="member">
                                <div class="member-picture"
                                     style="background-image:url('{{ route("file::get", ['id' => $user->photo]) }}');"></div>
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

                        @if (count($event->activity->backupUsers()) > 0)

                            <hr>

                            <p style="text-align: center;">
                                Back-up list:
                            </p>

                            @foreach($event->activity->backupUsers() as $user)

                                <div class="member">
                                    <div class="member-picture"
                                         style="background-image:url('{{ route("file::get", ['id' => $user->photo]) }}');"></div>
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