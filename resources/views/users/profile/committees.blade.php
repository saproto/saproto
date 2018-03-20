<h3>Committees</h3>

@if(count($user->committees) > 0)

    <ul class="list-group">
        @foreach($user->committees as $committee)
            <li class="list-group-item">
                {!! ($committee->public ? '<a href="' . route("committee::show", ["id" => $committee->getPublicId()]) . '">' : '') !!}
                <strong>
                    {{ $committee->name }}
                </strong>
                {{ ($committee->pivot->edition ? $committee->pivot->edition : '') }}
                {!! ($committee->public ? '</a>' : '') !!}

                ({{ ($committee->pivot->role ? $committee->pivot->role : 'General Member') }})
                <br>
                <sub>Since {{date('j F Y', strtotime($committee->pivot->created_at))}}.</sub>
            </li>
        @endforeach
    </ul>

@else

    <p>
        Currently not a member of a committee.
    </p>

@endif