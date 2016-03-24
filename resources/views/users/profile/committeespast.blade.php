@if(count($user->committeesFilter('past')) > 0)

    <h3>In the past</h3>

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
