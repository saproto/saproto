<h3>Committees</h3>

@if(count($user->committeesFilter('current')) > 0)

    <ul class="list-group">
        @foreach($user->committeesFilter('current') as $committee)
            <li class="list-group-item">
                {!! ($committee->public ? '<a href="' . route("committee::show", ["id" => $committee->id]) . '">' : '') !!}
                <strong>
                    {{ $committee->name }}
                </strong>
                {{ ($committee->pivot->edition ? $committee->pivot->edition : '') }}
                {!! ($committee->public ? '</a>' : '') !!}
                <br>
                <sub>As {{ ($committee->pivot->role ? $committee->pivot->role : 'General Member') }} since {{$committee->pivot->start}}</sub>
            </li>
        @endforeach
    </ul>

@else

    <p>
        Currently not a member of a committee.
    </p>

@endif