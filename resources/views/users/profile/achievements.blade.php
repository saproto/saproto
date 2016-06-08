<h3>Achievements</h3>

@if(count($user->achievements()) > 0)

    <ul class="list-group">

        @foreach($user->achievements() as $key => $achievement)

            <li class="list-group-item">

                <img src="{{ $achievements[$key]->img }}" alt="{{ $achievement[$key]->name }} icon"/>
                <strong>{{ $achievements[$key]->name }}</strong>
                <p>{{ $achievements[$key]->desc }}</p>
                <br>
                <sub>Aquired on {{date('j F Y', $achievements[$key]->name->date)}}.</sub>

            </li>

        @endforeach

    </ul>

@else

    <p>
        This person hasn't achieved a single thing.
    </p>

@endif