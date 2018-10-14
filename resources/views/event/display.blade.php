@extends('website.layouts.redesign.generic')

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

@section('container')

    <div class="row justify-content-center">

        <div class="col-md-4">

            @include('event.display_includes.event_details', [
                'event' => $event
            ])

        </div>

        @if($event->activity && Auth::check() && Auth::user()->member && $event->activity->withParticipants())

            <div class="col-md-3">

                @include('event.display_includes.participation', [
                    'event' => $event
                ])

            </div>

        @elseif($event->activity && $event->activity->withParticipants())

            <div class="col-md-3">

                <div class="card">
                    <div class="card-header text-center bg-dark text-white">
                        Participate in this activity.
                    </div>
                    <div class="card-body">
                        <p class="card-text">
                            This activity requires you to sign-up. You can only sign-up when you are a member.
                        </p>

                        @if(!Auth::check())
                            <p class="card-text">
                                Please <a href="{{ route('event::login', ['id' => $event->getPublicId()]) }}">log-in</a>
                                if you are already a member.
                            </p>
                        @elseif(!Auth::user()->member)
                            <p class="card-text">
                                Please <a href="{{ route('becomeamember') }}">become a member</a> to sign-up for this
                                activity.
                            </p>
                        @endif
                    </div>
                </div>

            </div>

        @endif

    </div>

    <div class="col-md-{{ (($event->activity && $event->activity->withParticipants()) ? '8' : '8 col-md-offset-2') }}">

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
                                    @if($instance->committee->isMember(Auth::user()) || Auth::user()->can('board'))
                                        ({{ $instance->users->count() }}/{{ $instance->amount }})
                                    @endif

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
                                                        <i class="fas fa-times" aria-hidden="true"></i>
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
                                                    <select class="form-control user-search" name="user_id"
                                                            required></select>
                                                    <span class="input-group-btn">
                                                            <button type="submit" class="btn btn-success">
                                                                <i class="fas fa-plus-circle" aria-hidden="true"></i>
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

@endsection
