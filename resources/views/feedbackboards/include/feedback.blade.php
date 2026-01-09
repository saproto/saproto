<div class="feedback card mb-3 h-100">
    <div class="card-header bg-dark text-reset">
        <span data-id="{{ $feedback->id }}">
            <span class="votes d-inline-block">
                {{ $feedback->votes_sum_vote ?? 0 }}
            </span>
            <span
                class="{{ $feedback->user_vote == 1 ? 'text-info' : 'text-white' }}"
            >
                <i class="upvote fas fa-thumbs-up cursor-pointer"></i>
            </span>
            <span
                class="{{ $feedback->user_vote == -1 ? 'text-danger' : 'text-white' }}"
            >
                <i class="downvote fas fa-thumbs-down cursor-pointer"></i>
            </span>
        </span>

        @if (! $feedback->reviewed && $feedback->category->review && ! $feedback->deleted_at && Auth::user()->id === $feedback->category->reviewer_id)
            <a
                href="{{ route('feedback::approve', ['id' => $feedback->id, 'id' => $feedback->id]) }}"
                class="float-end"
            >
                <i class="reply fa-solid fa-circle-check me-1"></i>
            </a>
        @endif

        @if ((Auth::user()->id == $feedback->user?->id && ! $feedback->reply) || (Auth::user()->can('board') && $feedback->deleted_at))
            @include(
                'components.modals.confirm-modal',
                [
                    'action' => route('feedback::delete', ['id' => $feedback->id]),
                    'text' => '<i class="delete fas fa-trash"></i>',
                    'title' => 'Confirm Delete',
                    'message' =>
                        'Are you sure you want to delete this potentially good feedback?',
                    'confirm' => 'Delete',
                    'classes' => 'float-end me-3',
                ]
            )
        @endif

        @can('board')
            @if (! $feedback->deleted_at)
                <a
                    href="{{ route('feedback::archive', ['id' => $feedback->id]) }}"
                    class="float-end"
                >
                    <i class="archive fas fa-box-archive hover-danger me-3"></i>
                </a>
                @if (! $feedback->reply && $feedback->category->can_reply && $controls)
                    <span class="float-end me-3 cursor-pointer">
                        <i
                            class="reply fas fa-reply toggle-navbar-{{ $feedback->id }}"
                        ></i>
                    </span>
                @endif
            @else
                <a
                    href="{{ route('feedback::archive', ['id' => $feedback->id]) }}"
                    class="float-end"
                >
                    <i class="restore fas fa-trash-restore me-3"></i>
                </a>
            @endif
        @endcan
    </div>

    <div class="card-body">
        {{-- format-ignore-start --}}
        <div style="white-space: pre-wrap">{{ $feedback->feedback }}</div>
        {{-- format-ignore-end --}}
        @if ($feedback->reply)
            <hr />
            <i
                class="fa {{ $feedback->accepted ? 'fa-circle-check text-primary' : 'fa-circle-xmark text-danger' }} me-1"
                aria-hidden="true"
            ></i>
            <b>Board:</b>
            {{ $feedback->reply }}
        @endif

        @if (Auth::user()->can('board') && $controls)
            <div
                class="collapse mt-3"
                id="feedback__{{ $feedback->id }}__collapse"
            >
                <form
                    method="post"
                    action="{{ route('feedback::reply', ['id' => $feedback->id]) }}"
                >
                    {{ csrf_field() }}
                    <label for="feedback__{{ $feedback->id }}__reply">
                        Reply:
                    </label>
                    <textarea
                        id="feedback__{{ $feedback->id }}__reply"
                        class="form-control mb-2"
                        rows="2"
                        cols="30"
                        name="reply"
                        placeholder="A reply to this {{ strtolower(str_singular($feedback->category->title)) }}."
                        required
                    >
{{ $feedback->reply ?? '' }}</textarea
                    >
                    <div class="btn-group w-100">
                        <button
                            type="submit"
                            name="responseBtn"
                            value="accept"
                            class="btn btn-primary"
                        >
                            <i class="fas fa-circle-check"></i>
                            Accept
                        </button>
                        <button
                            type="submit"
                            name="responseBtn"
                            value="reject"
                            class="btn btn-danger"
                        >
                            <i class="fas fa-circle-xmark"></i>
                            Reject
                        </button>
                    </div>
                    <p class="mt-1 text-center">
                        <i class="fas fa-triangle-exclamation"></i>
                        Replying will email this member.
                    </p>
                </form>
            </div>
        @endif
    </div>

    <div class="card-footer ps-0">
        <div class="text-muted mt-2 text-end">
            <em>
                <sub>
                    @if (Auth::user()->can('board') || $feedback->category->show_publisher)
                        By
                        {{ $feedback->user?->name ?? 'before we kept track!' }}
                        --
                    @endif

                    {{ $feedback->created_at->format('j M Y, H:i') }}
                </sub>
            </em>
        </div>
    </div>
</div>

@push('javascript')
    @if ($controls)
        <script type="text/javascript" @cspNonce>
            document
                .querySelectorAll('.toggle-navbar-{{ $feedback->id }}')
                .forEach((element) => {
                    element.addEventListener('click', () => {
                        const enabled = document
                            .getElementById(
                                'feedback__{{ $feedback->id }}__collapse'
                            )
                            .classList.toggle('show')
                        if (enabled) {
                            document
                                .getElementById(
                                    'feedback__{{ $feedback->id }}__reply'
                                )
                                .focus()
                        } else {
                            document.getElementById(
                                'feedback__{{ $feedback->id }}__reply'
                            ).value = ''
                        }
                    })
                })
        </script>
    @endif
@endpush
