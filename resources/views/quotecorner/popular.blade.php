@if($popular)

    <div class="panel panel-default container-panel">

        <div class="panel-body">

            <div id="popular">

                <?php $entry = $popular ?>

                <div>
                    <p>
                        <a href="{{ route('user::profile', ['id' => $entry->user->id]) }}">{{ $entry->user->name }}</a>
                        <span class="timestamp">{{ $entry->created_at->format("j M Y, H:m") }}</span>
                    </p>
                    <h4>{!! $entry["quote"] !!}</h4>
                    <div class="like">
                        <a href="{{ route('quotes::like', ['id' => $entry->id]) }}"><i
                                    class="fa fa-thumbs-up {{ $entry->liked(Auth::user()->id) ? "liked" : "" }}"></i></a>
                        {{ count($entry->likes()) }}
                    </div>
                    @if (Auth::check() && Auth::user()->can("board"))
                        <a href="{{ route('quotes::delete', ['id' => $entry->id]) }}"
                           style="float:right;">Remove</a>
                    @endif
                    <br>
                </div>

            </div>

        </div>

    </div>

@endif