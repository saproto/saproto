@foreach($participants as $user)

    <div class="btn btn-sm btn-success mb-1">

        <a href="{{ route("user::profile", ['id'=>$user->getPublicId()]) }}" class="text-white">{{ $user->name }}</a>

        @if(Auth::user()->can('board') && !$event->activity->closed)
            &nbsp;&nbsp;
            <a class="float-right text-white" href="{{ route('event::deleteparticipation', ['participation_id' => $user->pivot->id]) }}">
                <i class="fas fa-times" aria-hidden="true"></i>
            </a>
        @endif

    </div>

@endforeach