@foreach($participants as $user)

    <?php $pid = (get_class($user) == 'Proto\Models\User' ? $user->pivot->id : $user->id) ?>
    <?php $u = (get_class($user) == 'Proto\Models\User' ? $user : $user->user) ?>

    <div class="btn btn-sm btn-success mb-1">

        <a href="{{ route("user::profile", ['id' => $u->getPublicId()]) }}" class="text-white">{{ $u->name }}</a>

        @if(Auth::user()->can('board') && !$event->activity->closed)
            &nbsp;&nbsp;
            <a class="float-right text-white" href="{{ route('event::deleteparticipation', ['participation_id' => $pid]) }}">
                <i class="fas fa-times" aria-hidden="true"></i>
            </a>
        @endif

    </div>

@endforeach