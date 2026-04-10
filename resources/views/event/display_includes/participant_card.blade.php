<div
    class="btn-group btn-group-sm participant-id mb-1"
    data-user-id="{{ $user?->id }}"
>
    <a
        href="{{ route('user::profile', ['id' => $user?->getPublicId()]) }}"
        class="btn btn-outline-primary participant-profile-link"
    >
        <img
            src="{{ $user?->getFirstMediaUrl('profile_picture', 'thumb') }}"
            class="rounded-circle participant-avatar me-1"
            style="width: 21px; height: 21px; margin-top: -3px"
        />
        <span class="participant-name">{{ $user?->name }}</span>
    </a>
    @if (Auth::user()->can('board') && $event && ! $event->activity->closed)
        @include(
            'components.modals.confirm-modal',
            [
                'action' => route('event::deleteparticipation', ['event' => $event, 'user' => $user ?? 'replace_user_id']),
                'confirm' => "Remove $user?->name",
                'classes' => 'btn btn-outline-warning participant-remove-link',
                'text' => '<i class="fas fa-times" aria-hidden="true"></i>',
                'message' =>
                    "Are you sure you want to sign $user?->name out of this event?",
            ]
        )
    @endif
</div>
