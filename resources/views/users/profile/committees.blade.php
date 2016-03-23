@if(count($user->committeesFilter('current')) > 0)

    <h3>Committees</h3>

    <ul class="list-group">
        @foreach($user->committeesFilter('current') as $committee)
            <li class="list-group-item">
                <strong>
                    {{ $committee->name }}
                </strong>
                @if($committee->pivot->edition != null)
                    {{ $committee->pivot->edition }}
                @endif
                <br>
                <sub>As {{$committee->pivot->role}} since {{$committee->pivot->start}}</sub>
            </li>
        @endforeach
    </ul>

@else

    <h4>
        Currently not a member of a committee.
    </h4>

@endif

@if(count($user->committeesFilter('past')) > 0)

    <hr>

    <h4>In the past</h4>

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
                <sub>As {{$committee->pivot->role}} between {{$committee->pivot->start}}
                    and {{$committee->pivot->end}}</sub>
            </li>
        @endforeach
    </ul>

@endif
