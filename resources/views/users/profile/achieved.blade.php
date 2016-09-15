<h3 style="text-align:center;">Achievements</h3>

@if(count($user->achieved()) > 0)

    <ul class="list-group">

        @foreach($user->achieved() as $key => $achievement)

            <li class="list-group-item achievement {{ $achievement->tier }}">

                @if(Auth::check() && Auth::user()->can("board"))
                    <a class="del" href="{{ route('achievement::take', ['id' => $achievement->id, 'user' => $user->id]) }}">Remove</a>
                @endif

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
        Didn't achieve a single thing.
    </p>

@endif