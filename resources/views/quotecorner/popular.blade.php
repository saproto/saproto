@if($popular)

    <div class="panel panel-default container-panel">

        <div class="panel-body">

            <div id="qq_popular">

                <h2>Popular this week</h2>

                <br>

                <?php $entry = $popular ?>

                <div>
                    <p>
                        <a href="{{ route('user::profile', ['id' => $entry->user->getPublicId()]) }}">{{ $entry->user->name }}</a>
                        <span class="qq_timestamp">{{ $entry->created_at->format("j M Y, H:i") }}</span>
                    </p>
                    <h4>{!! $entry["quote"] !!}</h4>
                    <div class="qq_like" data-id="{{ $entry->id }}">
                        <i class="fa fa-thumbs-up {{ $entry->liked(Auth::user()->id) ? "qq_liked" : "" }}"></i>
                        <span>{{ count($entry->likes()) }}</span>
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