<div class="goodidea card mb-3 h-100">

    <div class="card-header bg-dark text-white">

        <span data-id="{{ $idea->id }}">
            <span class="votes d-inline-block">{{ $idea->voteScore() }}</span>
            <i class="upvote fa-thumbs-up {{ $idea->userVote(Auth::user()) == 1 ? "fas" : "far" }}"></i>
            <i class="downvote fa-thumbs-down {{ $idea->userVote(Auth::user()) == -1 ? "fas" : "far" }}"></i>
        </span>

        @if (Auth::user()->can("board"))
            <a href="{{ route('goodideas::archive', ['id' => $idea->id]) }}" class="float-end"><i
                        class="fas fa-file-archive text-white"></i></a>

            <a class="float-end me-2 toggle-navbar-{{$idea->id}}">
                <i class="fas fa-reply text-white"></i>
            </a>
        @endif



        @if (Auth::user()->id == $idea->user->id)
            @include('website.layouts.macros.confirm-modal', [
                                     'action' => route("goodideas::delete", ['id' => $idea->id]),
                                     'text' => '<i class="fas fa-trash text-white"></i>',
                                     'title' => 'Confirm Delete',
                                     'message' => "Are you sure you want to delete this potentially good idea?",
                                     'confirm' => 'Delete',
                            ])
        @endif

    </div>

    <div class="card-body">

        {!! $idea->idea !!}

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
    </div>

    <div class="card-footer ps-0">

        <div class="text-muted text-end mt-2">
            <em>
                <sub>
                    @can('board')
                        By {{ $idea->user->name }}
                    @endcan
                     -- {{ $idea->created_at->format("j M Y, H:i") }}
                </sub>
            </em>
        </div>
    </div>

</div>

@push('javascript')
    <script type="text/javascript" nonce="{{ csp_nonce() }}">
        document.querySelectorAll('.toggle-navbar-{{$idea->id}}').forEach((element)=>{
            console.log(element)
            element.addEventListener('click', (event)=>{
                document.getElementById("idea__{{ $idea->id }}__collapse").classList.toggle("show");
                console.log(document.getElementById("idea__{{ $idea->id }}__collapse"))
            })
        })
    </script>
@endpush
