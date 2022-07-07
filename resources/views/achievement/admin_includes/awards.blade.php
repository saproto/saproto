<div class="card mb-3">

    <div class="card-header bg-dark text-white">
        Awards
    </div>

    <div class="card-body">

        @if (count($achievement->currentOwners(false)) > 0)

            @foreach($achievement->currentOwners(false) as $user)

                <div class="badge bg-primary">
                    <a href="{{ route("user::profile", ['id'=>$user->getPublicId()]) }}" class="text-white">{{ $user->name }}</a>
                    <a href="{{ route('achievement::take', ['id' => $achievement->id, 'user' => $user->id]) }}" class="text-white">
                        <i class="fas fa-times ms-2"></i>
                    </a>
                </div>

            @endforeach

        @else

            <p class="card-text text-center">
                Nobody obtained this achievement yet
            </p>

        @endif

    </div>

    <div class="card-footer">

        <form method="post"
              action="{{ route("achievement::award", ['id' => $achievement->id]) }}">

            {!! csrf_field() !!}

            <div class="form-group autocomplete">
                <input class="form-control user-search" name="user-id"/>
            </div>

            <button type="submit" class="mt-3 btn btn-success btn-block">
                Award
            </button>

            <hr>

            @include('website.layouts.macros.confirm-modal', [
                'action' => route('achievement::takeAll', ['id' => $achievement->id]),
                'classes' => 'btn-outline-danger btn-block',
                'text' => 'Take from everyone',
                'message' => "Are you sure you want to take $achievement->name from everyone?",
            ])

        </form>

    </div>

</div>