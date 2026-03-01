<div class="card">
    <div class="card-header bg-dark text-white">
        People helping this activity
    </div>

    <ul class="list-group list-group-flush">
        @foreach ($event->activity->helpingCommittees as $instance)
            <li class="list-group-item">
                <p class="card-title">
                    <strong>
                        {{ $instance->committee->name }}
                        @if (Auth::user()->can('board') || Auth::user()->committees->contains($instance->committee))
                                ({{ $instance->users->count() }}/{{ $instance->amount }})
                        @endif
                    </strong>

                    @if ($instance->users->count() < 1)
                        <p class="card-text">
                            No people are currently helping.
                        </p>
                    @else
                        @include(
                            'event.display_includes.render_helper_list',
                            [
                                'participants' => $instance->users,
                                'event' => $event,
                                'helpingCommittee' => $instance,
                            ]
                        )
                    @endif

                    @if (! $event->activity->closed && $instance->committee->users->contains(Auth::user()))
                        @if ($instance->users->contains(Auth::user()))
                            <a
                                class="btn btn-outline-warning btn-block mt-1"
                                href="{{
                                    route('event::help::helper::delete', [
                                        'helpingCommittee' => $instance,
                                        'user' => Auth::user(),
                                    ])
                                }}"
                            >
                                I won't help anymore.
                            </a>
                        @elseif ($instance->users->count() < $instance->amount)
                            <form
                                method="post"
                                action="{{ route('event::help::helper::add', ['helpingCommittee' => $instance]) }}"
                            >
                                <button
                                    class="btn btn-outline-success btn-block mt-1"
                                >
                                    I'll help!
                                </button>
                                @csrf
                            </form>
                        @endif
                    @endif

                    @if (Auth::user()->can('board') && ! $event->activity->closed)
                        <form
                            class="form-horizontal mt-2"
                            method="post"
                            action="{{ route('event::help::helper::add', ['helpingCommittee' => $instance]) }}"
                        >
                            {{ csrf_field() }}

                            <div class="row mb-3">
                                <div class="col-9">
                                    <div class="form-group autocomplete">
                                        <input
                                            class="form-control user-search"
                                            name="user_id"
                                            required
                                        />
                                    </div>
                                </div>
                                <div class="col-3">
                                    <button
                                        class="btn btn-outline-primary btn-block"
                                        type="submit"
                                    >
                                        <i class="fas fa-plus-circle"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    @endif
                </p>
            </li>
        @endforeach
    </ul>
</div>
