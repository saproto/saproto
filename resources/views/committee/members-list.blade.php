@foreach($members['editions'] as $edition)

    <div class="panel panel-default members">

        <div class="panel-heading">{{ $committee->name }}
            <strong>{{ $edition[0]->pivot->edition }}</strong>
        </div>

        <div class="panel-body">

            @foreach($edition as $i => $member)

                <div class="member-picture"
                     style="background-image:url('{!! ($member->photo ? $member->photo->generateImagePath(100, 100) : '') !!}');"></div>

                @if(Route::current()->getName() == "committee::edit")
                    <a href="{{ route("committee::membership::edit", ['id' => $member->pivot->id]) }}">
                        <span class="label label-success"><i class="fa fa-pencil"></i></span>
                    </a>
                @endif
                <a href="{{ route('user::profile', ['id' => $member->id]) }}">{{ $member->name }}</a>
                ({{ ($member->pivot->role ? $member->pivot->role : 'General Member') }})
                <br>

                @if ($member->pivot->end)
                    Between {{ date('j F Y', $member->pivot->start) }}
                    and {{ date('j F Y',$member->pivot->end) }}.
                @else
                    Since {{ date('j F Y',$member->pivot->start) }}.
                @endif
                @if($i != count($edition) - 1)
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

            @foreach($members['members']['current'] as $i => $member)

                <div class="member-picture"
                     style="background-image:url('{!! ($member->photo ? $member->photo->generateImagePath(100, 100) : '') !!}');"></div>

                @if(Route::current()->getName() == "committee::edit")
                    <a href="{{ route("committee::membership::edit", ['id' => $member->pivot->id]) }}">
                        <span class="label label-success"><i class="fa fa-pencil"></i></span>
                    </a>
                @endif
                <a href="{{ route('user::profile', ['id' => $member->id]) }}">{{ $member->name }}</a>
                ({{ ($member->pivot->role ? $member->pivot->role : 'General Member') }})
                <br>

                @if ($member->pivot->end)
                    Between {{ date('j F Y',$member->pivot->start) }}
                    and {{ date('j F Y',$member->pivot->end) }}.
                @else
                    Since {{ date('j F Y',$member->pivot->start) }}.
                @endif
                @if($i != count($members['members']['current']) - 1)
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

            @foreach($members['members']['past'] as $i => $member)

                <div class="member-picture"
                     style="background-image:url('{!! ($member->photo ? $member->photo->generateImagePath(100, 100) : '') !!}');"></div>

                @if(Route::current()->getName() == "committee::edit")
                    <a href="{{ route("committee::membership::edit", ['id' => $member->pivot->id]) }}">
                        <span class="label label-success"><i class="fa fa-pencil"></i></span>
                    </a>
                @endif
                <a href="{{ route('user::profile', ['id' => $member->id]) }}">{{ $member->name }}</a>
                ({{ ($member->pivot->role ? $member->pivot->role : 'General Member') }})
                <br>

                @if ($member->pivot->end)
                    Between {{ date('j F Y',$member->pivot->start) }}
                    and {{ date('j F Y',$member->pivot->end) }}.
                @else
                    Since {{ date('j F Y',$member->pivot->start) }}.
                @endif
                @if($i != count($members['members']['past']) - 1)
                    <hr class="committee-seperator">
                @endif
                
            @endforeach

        </div>

    </div>

@endif
