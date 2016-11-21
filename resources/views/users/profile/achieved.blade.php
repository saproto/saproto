<h3>Achievements</h3>

@if(count($user->achieved()) > 0)

    <ul class="achievement-list">

        @foreach($user->achieved() as $key => $achievement)

            <li class="achievement {{ $achievement->tier }}">

                <div class="achievement-label">
                    <img src="{{ asset('images/achievements/' . strtolower($achievement->tier) . '.svg') }}" alt="">
                </div>

                <div class="achievement-icon">
                    @if($achievement->image)
                        <img src="{!! $achievement->image->generateImagePath(700,null) !!}" alt="">
                    @else
                        No icon available
                    @endif
                </div>

                <div class="achievement-tooltip">

                    <div class="achievement-button">
                        <img src="{{ asset('images/achievements/' . strtolower($achievement->tier) . '_tooltip.svg') }}" alt="">
                        <div class="achievement-button-icon">
                            @if($achievement->image)
                                <img src="{!! $achievement->image->generateImagePath(700,null) !!}" alt="">
                            @else
                                No icon available
                            @endif
                        </div>
                    </div>

                    <div class="achievement-text">

                        <div class="achievement-title">
                            <strong>{{ $achievement->name }}</strong>
                        </div>

                        <div class="achievement-desc">
                            <p>{{ $achievement->desc }}</p>
                        </div>

                        <div class="achievement-data">
                            <sub>Acquired on {{ $achievement->pivot->created_at->format('d/m/Y') }}.</sub>
                            @if(Auth::check() && Auth::user()->can("board"))
                                <a class="del"
                                   href="{{ route('achievement::take', ['id' => $achievement->id, 'user' => $user->id]) }}">Remove</a>
                            @endif
                        </div>

                    </div>

                </div>

            </li>

        @endforeach

    </ul>

@else

    <p>Working on their first achievement!</p>

@endif