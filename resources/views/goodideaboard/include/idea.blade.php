<div class="card mb-3 h-100">

    <div class="card-header bg-dark text-white">

        @if(!$idea->trashed())
            <span>

                <span data-id="{{ $idea->id }}" class="d-inline-block" style="width: 20px;">{{ $idea->voteScore() }}</span>
                <a data-id="{{ $idea->id }}" style="cursor: pointer"
                   class="gi_upvote gi_vote fa-thumbs-up {{ $idea->userVote(Auth::user()) == 1 ? "fas" : "far" }}"></a>
                <a data-id="{{ $idea->id }}" style="cursor: pointer"
                   class="gi_downvote gi_vote fa-thumbs-down {{ $idea->userVote(Auth::user()) == -1 ? "fas" : "far" }}"></a>

            </span>

            @if (Auth::user()->can("board"))
                <a href="{{ route('goodideas::archive', ['id' => $idea->id]) }}" class="badge badge-warning p-2 float-right ml-3">
                    <i class="fas fa-archive text-white"></i>
                </a>
                <a class="badge badge-info p-2 float-right ml-3" data-toggle="collapse" href="#idea__{{ $idea->id }}__collapse" role="button" aria-expanded="false" aria-controls="idea__{{ $idea->id }}__collapse">
                    <i class="fas fa-reply text-white"></i>
                </a>
            @endif

            @if (Auth::user()->id == $idea->user->id)
                <a href="{{ route('goodideas::delete', ['id' => $idea->id]) }}" onclick="return confirm('Are you sure you want to delete this potentially good idea?')" class="badge badge-danger p-2 float-right ml-3">
                    <i class="fas fa-trash text-white"></i>
                </a>
            @endif
        @else
            <span data-id="{{ $idea->id }}">{{ $idea->voteScore() }} Votes</span>
            <a href="{{ route('goodideas::restore', ['id' => $idea->id]) }}" class="badge badge-info p-2 float-right ml-3">
                <i class="fas fa-undo text-white"></i>
            </a>
            <a href="{{ route('goodideas::delete', ['id' => $idea->id]) }}" onclick="return confirm('Are you sure you want to delete this potentially good idea?')" class="badge badge-danger p-2 float-right ml-3">
                <i class="fas fa-trash text-white"></i>
            </a>
        @endif

    </div>

    <div class="card-body">

        @if (Auth::user()->can("board"))

            <div class="collapse mb-3" id="idea__{{ $idea->id }}__collapse">
                <form method="post" action="{{ route('goodideas::reply', ['id' => $idea->id]) }}">
                    {{ csrf_field() }}
                    <textarea class="form-control mb-2" rows="2" cols="30" name="reply"
                              placeholder="A reply to this amazing idea.">{!! $idea->reply ?? '' !!}</textarea>
                    <button type="submit" class="btn btn-success p-1 w-100">
                        <i class="fas fa-reply"></i>
                    </button>
                </form>
            </div>

        @endif

        {!! $idea->idea !!}

        @if ($idea->reply)

            <hr>

            <p><b>board:</b> {!! $idea->reply !!}</p>

        @endif
    </div>

    <div class="card-footer pt-0 pl-0">

        <div class="text-muted text-right">
            <em>
                <sub>
                    @if(Auth::user()->can('board'))
                        By {{ $idea->user->name }} --
                    @endif
                    {{ $idea->created_at->format("j M Y, H:i") }}
                </sub>
            </em>
        </div>
    </div>

</div>
