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

                ({{ ($committee->pivot->role ? $committee->pivot->role : 'General Member') }})
                <br>
                <sub>
                    Between {{date('j F Y', $committee->pivot->start)}} and {{date('j F Y', $committee->pivot->end)}}.
                </sub>
            </li>
        @endforeach
    </ul>

@endif