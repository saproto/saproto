<h3>Achievements</h3>

@if(count($user->achieved()) > 0)

    <ul class="list-group">

        @foreach($user->achieved() as $key => $achievement)

            <li class="list-group-item achievement {{ $achievement->tier }}">

                <a class="del" href="{{ route('achievement::take', ['id' => $achievement->id, 'user' => $user->id]) }}">Remove</a>

                <img src="{{ $achievement->img_file_id }}" alt="{{ $achievement->name }} icon"/>
                <div>
                    <strong>{{ $achievement->name }}</strong>
                    <p>{{ $achievement->desc }}</p>
                    <sub>Acquired on {{ $achievement->pivot->created_at->format('d/m/Y') }}.</sub>
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

        .list-group .achievement {
            overflow: hidden;
            word-wrap: break-word;
            border-width: 5px;
            /*border-top-left-radius: 5px;*/
            /*border-top-right-radius: 5px;*/
            /*border-bottom-right-radius: 5px;*/
            /*border-bottom-left-radius: 5px;*/
        }

        .del {
            position: absolute;
            right: 5px;
            top: 0;
            font-size:12px;
        }

        .COMMON {
            border-color: #FFFFFF;
        }

        .UNCOMMON {
            border-color: #1E90FF;
        }

        .RARE {
            border-color: #9932CC;
        }

        .EPIC {
            border-color: #333333;
        }

        .LEGENDARY {
            border-color: #C1FF00;
        }

    </style>

@endsection