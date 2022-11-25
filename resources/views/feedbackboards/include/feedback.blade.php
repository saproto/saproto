<div class="goodidea card mb-3 h-100">

    <div class="card-header bg-dark text-white">

        <span data-id="{{ $feedback->id }}">
            <span class="votes d-inline-block">{{ $feedback->voteScore() }}</span>
            <i class="upvote fa-thumbs-up {{ $feedback->userVote(Auth::user()) == 1 ? "fas" : "far" }}"></i>
            <i class="downvote fa-thumbs-down {{ $feedback->userVote(Auth::user()) == -1 ? "fas" : "far" }}"></i>
        </span>

        @if (Auth::user()->can("board"))
            <a href="{{ route('feedback::archive', ['id' => $feedback->id]) }}" class="float-end"><i
                        class="fas fa-file-archive text-white"></i></a>
            @if(!$feedback->reply)
                <a class="float-end me-2 toggle-navbar-{{$feedback->id}}">
                    <i class="fas fa-reply text-white"></i>
                </a>
            @endif
        @endif



        @if (Auth::user()->id == $feedback->user->id)
            @include('website.layouts.macros.confirm-modal', [
                                     'action' => route("feedback::delete", ['id' => $feedback->id]),
                                     'text' => '<i class="fas fa-trash text-white"></i>',
                                     'title' => 'Confirm Delete',
                                     'message' => "Are you sure you want to delete this potentially good idea?",
                                     'confirm' => 'Delete',
                            ])
        @endif

    </div>

    <div class="card-body">

        {!! $feedback->feedback !!}

        @if ($feedback->reply)

            <hr>

            <b>board:</b> {!! $feedback->reply !!}

        @endif

        @if (Auth::user()->can("board"))

            <div class="collapse mt-3" id="idea__{{ $feedback->id }}__collapse">
                <form method="post" action="{{ route('feedback::reply', ['id' => $feedback->id]) }}">
                    {{ csrf_field() }}
                    <textarea class="form-control mb-2" rows="2" cols="30" name="reply"
                              placeholder="A reply to this idea." required>{!! $feedback->reply ?? '' !!}</textarea>
                    <div class="btn-group w-100">
                            <button type="submit" name="responseBtn" value="accept" class="btn btn-success">
                                <i class="fas fa-reply"></i> reject
                            </button>
                            <button type="submit"  name="responseBtn" value="reject" class="btn btn-danger">
                                <i class="fas fa-reply"></i> accept
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
        document.querySelectorAll('.toggle-navbar-{{$feedback->id}}').forEach((element)=>{
            element.addEventListener('click', (event)=>{
                document.getElementById("idea__{{ $feedback->id }}__collapse").classList.toggle("show");
                console.log(document.getElementById("idea__{{ $feedback->id }}__collapse"))
            })
        })
    </script>
@endpush
