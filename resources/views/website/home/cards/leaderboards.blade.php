@php
    $leaderboard = App\Models\Leaderboard::where('featured', true)
        ->with('entries', function ($q) {
            $q->orderBy('points', 'DESC')->limit(5);
        })
        ->first();
@endphp

@if ($leaderboard)
    <div class="card mb-3">
        <div
            class="card-header bg-dark"
            data-bs-toggle="collapse"
            data-bs-target="#collapse-leaderboard-{{ $leaderboard->id }}"
        >
            <i class="fa {{ $leaderboard->icon }}"></i>
            {{ $leaderboard->name }} Leaderboard
        </div>

        @if ($leaderboard->entries->count() > 0)
            <table class="table-sm mb-0 table">
                @foreach ($leaderboard->entries as $entry)
                    <tr>
                        <td
                            class="place-{{ $loop->index + 1 }} ps-3"
                            style="max-width: 50px"
                        >
                            <i
                                class="fas fa-sm fa-fw {{ $loop->index == 0 ? 'fa-crown' : 'fa-hashtag' }}"
                            ></i>
                            {{ $loop->index + 1 }}
                        </td>
                        <td>
                            @if ($entry->user)
                                {{ $entry->user->name }}
                            @else
                                <del>Deleted User</del>
                            @endif
                        </td>
                        <td class="pe-4">
                            <i class="fa {{ $leaderboard->icon }}"></i>
                            {{ $entry->points }}
                        </td>
                    </tr>
                @endforeach
            </table>
        @else
            <hr />
            <p class="text-muted pt-3 text-center">There are no entries yet.</p>
        @endif

        <div class="p-3">
            <a
                href="{{ route('leaderboards::index') }}"
                class="btn btn-info btn-block"
            >
                Go to leaderboards
            </a>
        </div>
    </div>
@endif
