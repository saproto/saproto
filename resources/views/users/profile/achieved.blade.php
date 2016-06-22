<h3>Achievements</h3>

@if(count($user->achieved()) > 0)

    <ul class="list-group">

        @foreach($user->achieved() as $key => $achievement)

            <li class="list-group-item achievement">

                <img src="{{ $achievement->img_file_id }}" alt="{{ $achievement->name }} icon"/>
                <div>
                    <strong>{{ $achievement->name }}</strong>
                    <p>{{ $achievement->desc }}</p>
                    <sub>Acquired on {{ $achievement->pivot->created_at->format('m/d/Y') }}.</sub>
                </div>

            </li>

        @endforeach

    </ul>

@else

    <p>
        Didn't achieved a single thing.
    </p>

@endif

@section('stylesheet')

    @parent

    <style type="text/css">

        .achievement img, .achievement div {
            float: left;
            width: 50%;
            padding: 10px;
        }

        .achievement {
            overflow: hidden;
            word-wrap: break-word;
        }

    </style>

@endsection