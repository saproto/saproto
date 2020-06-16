@if($leastVoted)

    <div class="card mb-3">

        <div class="card-header bg-dark text-white">
            Least voted Idea
        </div>

        <div class="card-body">

            @include('goodideaboard.include.idea', [
            'idea' => $leastVoted
            ])

        </div>

    </div>

@endif