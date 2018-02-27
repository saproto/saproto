@if(count($pastcommittees) > 0)

    <h3>In the past</h3>

    <ul class="list-group">
        @foreach($pastcommittees as $committeeparticipation)
            <li class="list-group-item">
                {!! ($committeeparticipation->committee->public ? '<a href="' . route("committee::show", ["id" => $committeeparticipation->committee->getPublicId()]) . '">' : '') !!}
                <strong>
                    {{ $committeeparticipation->committee->name }}
                </strong>
                {{ ($committeeparticipation->edition ? $committeeparticipation->edition : '') }}
                {!! ($committeeparticipation->committee->public ? '</a>' : '') !!}

                ({{ ($committeeparticipation->role ? $committeeparticipation->role : 'General Member') }})
                <br>
                <sub>
                    Between {{ date('j F Y', strtotime($committeeparticipation->created_at)) }}
                    and {{ date('j F Y', strtotime($committeeparticipation->deleted_at)) }}.
                </sub>
            </li>
        @endforeach
    </ul>

@endif
