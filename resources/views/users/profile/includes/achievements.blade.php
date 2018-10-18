@if(count($user->achieved()) > 0)

    <div class="card mb-3">

        <div class="card-header">
            Unlocked achievements
        </div>

        <div class="card-body">

            @foreach($user->achieved() as $key => $achievement)

                @include('achievement.includes.achievement_include', [
                'achievement' => $achievement,
                'include_delete_for' => (Auth::check() && Auth::user()->can("board") ? $user : null),
                'footer' => sprintf("Achieved on %s.", $achievement->pivot->created_at->format('d/m/Y'))
                ])

            @endforeach

        </div>

    </div>

@endif
