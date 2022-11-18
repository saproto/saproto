@if($mostVoted)

    <div class="card mb-3">

        <div class="card-header bg-dark text-white">
            Most upvoted idea
        </div>

        <div class="card-body">

            @include('goodideaboard.include.idea', [
            'idea' => $mostVoted
            ])

        </div>

    </div>

@endif