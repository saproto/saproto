@if(count($user->committeesFilter('current')) > 0)

    <h3>In the past</h3>

    <ul class="list-group">
        @foreach($user->committeesFilter('past') as $committee)
            <li class="list-group-item">
                {!! ($committee->public ? '<a href="' . route("committee::show", ["id" => $committee->id]) . '">' : '') !!}
                <strong>
                    {{ $committee->name }}
                </strong>
                {{ ($committee->pivot->edition ? $committee->pivot->edition : '') }}
                {!! ($committee->public ? '</a>' : '') !!}
                <br>
                <sub>As {{$committee->pivot->role}} since {{$committee->pivot->start}}</sub>
            </li>
        @endforeach
    </ul>

@endif