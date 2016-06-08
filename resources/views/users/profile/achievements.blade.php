<h3>Achievements</h3>

@if(count($user->achieved()) > 0)

    <ul class="list-group">

        @foreach($user->achieved() as $key => $achievement)

            <li class="list-group-item">

                <img src="{{ $achievement->img_file_id }}" alt="{{ $achievement->name }} icon"/>
                <strong>{{ $achievement->name }}</strong>
                <p>{{ $achievement->desc }}</p>
                <br>
                <sub>Aquired on {{ $achievement->pivot->created_at->format('m/d/Y') }}.</sub>

            </li>

        @endforeach

    </ul>

@else

    <p>
        Didn't achieved a single thing.
    </p>

@endif