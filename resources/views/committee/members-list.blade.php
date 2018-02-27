@foreach($members['editions'] as $edition => $memberships)

    <div class="panel panel-default members">

        <div class="panel-heading">{{ $committee->name }}
            <strong>{{ $edition }}</strong>
        </div>

        <div class="panel-body">

            @foreach($memberships as $i => $membership)

                <div class="member-picture"
                     style="background-image:url('{!! $membership->user->generatePhotoPath(100, 100) !!}');"></div>

                @if(Route::current()->getName() == "committee::edit")
                    <a href="{{ route("committee::membership::edit", ['id' => $membership->id]) }}">
                        <span class="label label-success"><i class="fa fa-pencil"></i></span>
                    </a>
                @endif
                <a href="{{ route('user::profile', ['id' => $membership->user->getPublicId()]) }}">{{ $membership->user->name }}</a>
                ({{ ($membership->role ? $membership->role : 'General Member') }})
                <br>

                @if ($membership->trashed())
                    Between {{ date('j F Y', strtotime($membership->created_at)) }}
                    and {{ date('j F Y', strtotime($membership->deleted_at)) }}.
                @else
                    Since {{ date('j F Y', strtotime($membership->created_at)) }}.
                @endif
                @if($i != count($memberships) - 1)
                    <hr class="committee-seperator">
                @endif

            @endforeach

        </div>

    </div>

@endforeach

@if(count($members['members']['current']) > 0)

    <div class="panel panel-default">

        <div class="panel-heading">
            Current members
        </div>

        <div class="panel-body">

            @foreach($members['members']['current'] as $i => $membership)

                <div class="member-picture"
                     style="background-image:url('{!! $membership->user->generatePhotoPath(100, 100) !!}');"></div>

                @if(Route::current()->getName() == "committee::edit")
                    <a href="{{ route("committee::membership::edit", ['id' => $membership->id]) }}">
                        <span class="label label-success"><i class="fa fa-pencil"></i></span>
                    </a>
                @endif
                <a href="{{ route('user::profile', ['id' => $membership->user->getPublicId()]) }}">{{ $membership->user->name }}</a>
                ({{ ($membership->role ? $membership->role : 'General Member') }})
                <br>

                @if ($membership->trashed())
                    Between {{ date('j F Y', strtotime($membership->created_at)) }}
                    and {{ date('j F Y', strtotime($membership->deleted_at)) }}.
                @else
                    Since {{ date('j F Y', strtotime($membership->created_at)) }}.
                @endif

                @if($i != count($members['members']['current']) - 1)
                    <hr class="committee-seperator">
                @endif

            @endforeach

        </div>

    </div>

@endif

@if(count($members['members']['future']) > 0)

    <div class="panel panel-default">

        <div class="panel-heading">
            Future members
        </div>

        <div class="panel-body">

            @foreach($members['members']['future'] as $i => $membership)

                <div class="member-picture"
                     style="background-image:url('{!! $membership->user->generatePhotoPath(100, 100) !!}');"></div>

                @if(Route::current()->getName() == "committee::edit")
                    <a href="{{ route("committee::membership::edit", ['id' => $membership->id]) }}">
                        <span class="label label-success"><i class="fa fa-pencil"></i></span>
                    </a>
                @endif
                <a href="{{ route('user::profile', ['id' => $membership->user->getPublicId()]) }}">{{ $membership->user->name }}</a>
                ({{ ($membership->role ? $membership->role : 'General Member') }})
                <br>

                @if ($membership->trashed())
                    From {{ date('j F Y', strtotime($membership->created_at)) }}
                    till {{ date('j F Y', strtotime($membership->deleted_at)) }}.
                @else
                    Starts {{ date('j F Y', strtotime($membership->created_at)) }}.
                @endif

                @if($i != count($members['members']['future']) - 1)
                    <hr class="committee-seperator">
                @endif

            @endforeach

        </div>

    </div>

@endif

@if(count($members['members']['past']) > 0)

    <div class="panel panel-default">

        <div class="panel-heading">
            Past members
        </div>

        <div class="panel-body">

            @foreach($members['members']['past'] as $i => $membership)

                <div class="member-picture"
                     style="background-image:url('{!! $membership->user->generatePhotoPath(100, 100) !!}');"></div>

                @if(Route::current()->getName() == "committee::edit")
                    <a href="{{ route("committee::membership::edit", ['id' => $membership->id]) }}">
                        <span class="label label-success"><i class="fa fa-pencil"></i></span>
                    </a>
                @endif
                <a href="{{ route('user::profile', ['id' => $membership->user->getPublicId()]) }}">{{ $membership->user->name }}</a>
                ({{ ($membership->role ? $membership->role : 'General Member') }})
                <br>

                @if ($membership->trashed())
                    Between {{ date('j F Y', strtotime($membership->created_at)) }}
                    and {{ date('j F Y', strtotime($membership->deleted_at)) }}.
                @else
                    Since {{ date('j F Y', strtotime($membership->created_at)) }}.
                @endif

                @if($i != count($members['members']['past']) - 1)
                    <hr class="committee-seperator">
                @endif

            @endforeach

        </div>

    </div>

@endif
