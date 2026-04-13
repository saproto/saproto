@php
    use App\Models\User;
@endphp

@foreach ($participants as $user)
    <?php $u = $user::class == User::class ? $user : $user->user; ?>

    <div class="btn-group btn-group-sm mb-1">
        <a
            href="{{ route('user::profile', ['id' => $u->getPublicId()]) }}"
            class="btn btn-outline-primary"
        >
            <img
                src="{{ $u->getFirstMediaUrl('profile_picture', 'thumb'), }}"
                class="rounded-circle me-1"
                style="width: 21px; height: 21px; margin-top: -3px"
            />
            {{ $u->name }}
        </a>
        @if (Auth::user()->can('board') && $event && ! $event->activity->closed)
            @include(
                'components.modals.confirm-modal',
                [
                    'action' => route('event::help::helper::delete', [
                        'helpingCommittee' => $helpingCommittee,
                        'user' => $u,
                    ]),
                    'confirm' => "Remove $user?->name as helper",
                    'classes' => 'btn btn-outline-warning',
                    'text' => '<i class="fas fa-times" aria-hidden="true"></i>',
                    'message' => "Are you sure you want to remove $user?->name as helper?",
                    'confirmButtonVariant' => 'btn-warning',
                ]
            )
        @endif
    </div>
@endforeach
