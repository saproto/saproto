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

            @if (Auth::user()->can("board") || Auth::user()->id == $idea->user->id)
                <a href="{{ route('goodideas::archive', ['id' => $idea->id]) }}" class="badge badge-warning p-2 float-right ml-3">
                    <i class="fas fa-archive text-white mr-1"></i> Archive
                </a>
            @endif
        @else
            <span data-id="{{ $idea->id }}">{{ $idea->voteScore() }} Votes</span>
            <a href="{{ route('goodideas::restore', ['id' => $idea->id]) }}" class="badge badge-info p-2 float-right ml-3">
                <i class="fas fa-undo text-white mr-1"></i> Restore
            </a>
            <a href="{{ route('goodideas::delete', ['id' => $idea->id]) }}" onclick="return confirm('Are you sure you want to delete this potentially good idea?')" class="badge badge-danger p-2 float-right ml-3">
                <i class="fas fa-trash text-white mr-1"></i> Delete
            </a>
        @endif

    </div>

    <div class="card-body">

        {!! $idea->idea !!}


    </div>
    @if(Auth::user()->can('board'))
    <div class="card-footer pt-0 pl-0">

        <div class="text-muted text-right">
            <em>
                <sub>
                    By {{ $idea->user->name }}
                     -- {{ $idea->created_at->format("j M Y, H:i") }}
                </sub>
            </em>
        </div>
    </div>
    @endif

</div>
