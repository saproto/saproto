<div class="goodidea card mb-3 h-100">

    <div class="card-header bg-dark text-white">
            <span data-id="{{ $feedback->id }}">
                <span class="votes d-inline-block">{{ $feedback->voteScore() }}</span>
                    <i class="upvote fa-thumbs-up {{ $feedback->userVote(Auth::user()) == 1 ? "fas" : "far" }}"></i>
                    <i class="downvote fa-thumbs-down {{ $feedback->userVote(Auth::user()) == -1 ? "fas" : "far" }}"></i>
            </span>

        @if(!$feedback->reviewed && $feedback->category->review &&Auth::user()->id===$feedback->category->reviewer_id)
            <a href="{{ route('feedback::approve', ['id' => $feedback->id, 'id' => $feedback->id]) }}" class="float-end"><i class="ms-2 fa-solid fa-circle-check"></i></a>
        @endif

        @if (Auth::user()->can("board"))
            @if(!$feedback->deleted_at)
            <a href="{{ route('feedback::archive', ['id' => $feedback->id]) }}" class="float-end"><i
                        class="fas fa-file-archive text-white"></i></a>
            @else
                <a href="{{ route('feedback::archive', ['id' => $feedback->id]) }}" class="float-end"><i
                            class="fas fa-trash-restore text-white"></i></a>
            @endif

            @if(!$feedback->reply && $feedback->category->can_reply && $controls)
                <a class="float-end me-2 toggle-navbar-{{$feedback->id}}">
                    <i class="fas fa-reply text-white"></i>
                </a>
            @endif
        @endif



        @if (Auth::user()->id == $feedback->user->id)
            @include('components.modals.confirm-modal', [
                                     'action' => route("feedback::delete", ['id' => $feedback->id]),
                                     'text' => '<i class="fas fa-trash text-white"></i>',
                                     'title' => 'Confirm Delete',
                                     'message' => "Are you sure you want to delete this potentially good feedback?",
                                     'confirm' => 'Delete',
                            ])
        @endif

    </div>

    <div class="card-body">
            {!! $feedback->feedback !!}

            @if ($feedback->reply)
                <hr>
                <i class="fa {{$feedback->accepted ? "fa-check":"fa-xmark"}}" aria-hidden="true"></i>
                <b>board:</b> {!! $feedback->reply !!}
            @endif

            @if (Auth::user()->can("board") && $controls)

                <div class="collapse mt-3" id="idea__{{ $feedback->id }}__collapse">
                    <form method="post" action="{{ route('feedback::reply', ['id' => $feedback->id]) }}">
                        {{ csrf_field() }}
                        <textarea class="form-control mb-2" rows="2" cols="30" name="reply"
                                  placeholder="A reply to this idea." required>{!! $feedback->reply ?? '' !!}</textarea>
                        <div class="btn-group w-100">
                                <button type="submit" name="responseBtn" value="accept" class="btn btn-primary">
                                    <i class="fas fa-reply"></i> accept
                                </button>
                                <button type="submit"  name="responseBtn" value="reject" class="btn btn-danger">
                                    <i class="fas fa-reply"></i> reject
                                </button>
                        </div>
                    </form>
                </div>
            @endif
    </div>


    <div class="card-footer ps-0">

        <div class="text-muted text-end mt-2">
            <em>
                <sub>
                    @can('board')
                        By {{ $feedback->user->name }}
                    @endcan
                     -- {{ $feedback->created_at->format("j M Y, H:i") }}
                </sub>
            </em>
        </div>
    </div>

</div>

@push('javascript')
    <script type="text/javascript" nonce="{{ csp_nonce() }}">
        if({{ isset($controls) }}) {
            document.querySelectorAll('.toggle-navbar-{{ $feedback->id }}').forEach((element) => {
                element.addEventListener('click', (event) => {
                    document.getElementById("idea__{{ $feedback->id }}__collapse").classList.toggle("show");
                })
            })
        }
    </script>
@endpush
