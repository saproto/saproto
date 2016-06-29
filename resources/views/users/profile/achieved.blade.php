<h3>Achievements</h3>

@if(count($user->achieved()) > 0)

    <ul class="list-group">

        @foreach($user->achieved() as $key => $achievement)

            <li class="list-group-item achievement {{ $achievement->tier }}">

                <a class="del" href="{{ route('achievement::take', ['id' => $achievement->id, 'user' => $user->id]) }}">Remove</a>

                <div class="achievement-icon">
                    @if($achievement->image)
                        <img src="{!! $achievement->image->generateImagePath(700,null) !!}" alt="">
                    @else
                        No icon available
                    @endif
                </div>
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

        .achievement div {
            float: right;
            width: 50%;
            padding: 10px;
            padding-bottom: 0;
        }

        .achievement .achievement-icon {
            padding:0;
            text-align:center;
            max-width:calc(50% - 20px);
            height:calc(100% - 20px);
            top:50%;
            position: absolute;
            transform:translate(0, -50%);
        }

        .list-group {
            margin-bottom:0;
        }

        .achievement-icon img {
            height: 100px;
            max-width: 100%;
            top:50%;
            left:50%;
            position: absolute;
            transform:translate(-50%, -50%);
        }

        .achievement {
            margin-top:5px;
            overflow: hidden;
            word-wrap: break-word;
            border-width: 5px;
            position: relative;
        }

        .del {
            position: absolute;
            right: 5px;
            top: 0;
            font-size:12px;
        }

        .COMMON {
            border-color: #DDDDDD;
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