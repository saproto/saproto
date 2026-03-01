<div class="btn-group btn-group-sm mb-1">
    <a
        href="{{ route('user::profile', ['id' => $user?->getPublicId()]) }}"
        class="btn btn-outline-primary participant-profile-link"
    >
        <img
            src="{{ $user?->getFirstMediaUrl('profile_picture', 'thumb') }}"
            class="rounded-circle me-1 participant-avatar"
            style="width: 21px; height: 21px; margin-top: -3px"
        />
        <span class="participant-name">{{ $user?->name }}</span>

    </a>
    @if (Auth::user()->can('board') && $event && ! $event->activity->closed)
        <a
            href="{{ route('event::deleteparticipation', ['event' => $event, 'user' => $user??'replace_user_id']) }}"
            class="btn btn-outline-warning participant-remove-link"
        >
            <i class="fas fa-times" aria-hidden="true"></i>
        </a>
    @endif
</div>
