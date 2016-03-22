@if(count($user->committeesFilter('current')) > 0)

    <h4>Member of {{ count($user->committeesFilter('current')) }} committees</h4>

    @foreach($user->committeesFilter('current') as $committee)
        <div class="panel panel-default" style="text-align: center;">
            <div class="panel-body">
                <strong>
                    {{ $committee->name }}
                </strong>
                @if($committee->pivot->edition != null)
                    {{ $committee->pivot->edition }}
                @endif
                <br>
                <sub>As {{$committee->pivot->role}} since {{$committee->pivot->start}}</sub>
            </div>
        </div>
    @endforeach

@else

    <h4>
        Currently not a member of a committee.
    </h4>

@endif

@if(count($user->committeesFilter('past')) > 0)

    <hr>

    <h4>Has been a member of {{ count($user->committeesFilter('past')) }} committees</h4>

    <ul class="list-group">
        @foreach($user->committeesFilter('past') as $committee)
            <li class="list-group-item">
                <strong>
                    {{ $committee->name }}
                </strong>
                @if($committee->pivot->edition != null)
                    {{ $committee->pivot->edition }}
                @endif
                <br>
                <sub>As {{$committee->pivot->role}} between {{$committee->pivot->start}} and {{$committee->pivot->end}}</sub>
            </li>
        @endforeach
    </ul>

@endif
