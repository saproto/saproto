<div class="card mb-3">

    <ul class="list-group list-group-flush text-center">

        @if (($event->isEventAdmin(Auth::user()) || Auth::user()->can('board')) && $event->activity->closed)
            <li class="list-group-item bg-danger text-white">
                This activity is closed and cannot be changed anymore.
            </li>
        @endif

        @if($event->activity->getParticipation(Auth::user()) !== null)
            @if ($event->activity->getParticipation(Auth::user())->backup)
                <li class="list-group-item bg-warning text-white">
                    You are on the <strong>back-up list</strong>.
                </li>
            @else
                <li class="list-group-item bg-success text-white">
                    You are signed up for this activity!
                </li>
            @endif
        @else
            <li class="list-group-item">
                You are <strong>not signed up</strong> for this activity.
            </li>
        @endif

        @if ($event->activity->no_show_fee > 0)
            <a href="#" class="list-group-item bg-warning text-white" data-toggle="modal" data-target="#noshow-modal">
                <i class="fas fa-info-circle" aria-hidden="true"></i>&nbsp;&nbsp;Not showing up can cost you
                &euro;{{ number_format($event->activity->no_show_fee + $event->activity->price, 2, '.', ',') }}
            </a>
        @endif

        @if($event->activity->getParticipation(Auth::user()) !== null)
            @if($event->activity->canUnsubscribe() || $event->activity->getParticipation(Auth::user())->backup)
                <a class="list-group-item bg-warning text-white"
                   href="{{ route('event::deleteparticipation', ['participation_id' => $event->activity->getParticipation(Auth::user())->id]) }}">
                    @if ($event->activity->getParticipation(Auth::user())->backup)
                        Sign me out of the back-up list.
                    @else
                        Sign me out. <i class="fas fa-frown-o" aria-hidden="true"></i>
                    @endif
                </a>
            @endif
        @else
            @if($event->activity->canSubscribeBackup())
                <a class="list-group-item text-white bg-{{ ($event->activity->isFull() || !$event->activity->canSubscribe() ? 'warning' : 'success') }}"
                   href="{{ route('event::addparticipation', ['id' => $event->id]) }}">
                    <strong>
                        @if ($event->activity->isFull() || !$event->activity->canSubscribe())
                            {{ ($event->activity->isFull() ? 'Full!' : 'Closed!') }}
                            Put me on the back-up list.
                        @else
                            Sign me up!
                        @endif
                    </strong>

                    Activity cost:

                    <strong>
                        @if ($event->activity->price > 0)
                        &euro;{{ number_format($event->activity->price, 2, '.', ',') }}
                        @else
                        &euro;0,-
                        @endif
                    </strong>
                </a>
            @endif
        @endif

        @if($event->activity->canSubscribe())
            <li class="list-group-item">
                @if($event->activity->participants != -1)
                    {{ ($event->activity->freeSpots() == -1 ? 'unlimited' : $event->activity->freeSpots()) }}
                    out of {{ $event->activity->participants }} places available
                @else
                    Unlimited places available.
                @endif
            </li>
        @endif

        <li class="list-group-item">Vestibulum at eros</li>

    </ul>

    <div class="card-body">

        <p class="card-text text-center">
            <strong>Sign up opens:</strong> {{ date('F j, H:i', $event->activity->registration_start) }}
            <br>
            <strong>Sign up closes:</strong> {{ date('F j, H:i', $event->activity->registration_end) }}
            <br>
            <strong>Sign out possible
                until:</strong> {{ date('F j, H:i', $event->activity->deregistration_end) }}
        </p>

    </div>

</div>

@if($event->activity->users->count() > 0)

    <div class="card mb-3">

        <div class="card-header text-center bg-dark text-white">
            {{ $event->activity->users->count() }} participants
        </div>

        <div class="card-body">

            @include('event.display_includes.render_participant_list', [
                'participants' => $event->activity->users
            ])

        </div>

        <div class="card-footer">

            @if(Auth::user()->can('board') && !$event->activity->closed)

                <div class="panel-footer clearfix">
                    <div class="form-group">
                        <div id="user-select">
                            <form class="form-horizontal"
                                  action="{{ route("event::addparticipationfor", ['id' => $event->id]) }}"
                                  method="post">

                                {{ csrf_field() }}

                                <div class="input-group">
                                    <select class="form-control user-search" name="user_id" required></select>
                                    <span class="input-group-btn">
                                                <button type="submit" class="btn btn-sm btn-success">
                                                    <i class="fas fa-plus-circle" aria-hidden="true"></i>
                                                </button>
                                            </span>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>

            @endif

        </div>

    </div>

@endif

@if($event->activity->backupUsers->count() > 0)

    <div class="card">

        <div class="card-header text-center bg-dark text-white">
            {{ $event->activity->backupUsers->count() }} people on the back-up list
        </div>

        <div class="card-body">

            @include('event.display_includes.render_participant_list', [
                'participants' => $event->activity->backupUsers
            ])

        </div>
    </div>

@endif

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