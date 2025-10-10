<div class="card leftborder leftborder-info mb-3">
    <div class="card-body">
        @if ($user->is_member)
            <img
                width="50px"
                height="50px"
                class="rounded-circle float-end"
                alt="{{ $user->name }}'s photo"
                src="{!! $user->getFirstMediaUrl('profile_picture', 'preview') !!}"
            />
            <a
                href="{{ route('user::profile', ['id' => $user->getPublicId()]) }}"
            >
                <strong>{{ $user->name }}</strong>
                <br />
            </a>
        @else
            <span class="text-muted">{{ $user->name }}</span>
            <br />
        @endif
        <div class="ellipsis">
            {!! $subtitle !!}
        </div>
    </div>
    @if (! empty($footer))
        <div class="card-footer">
            {!! $footer !!}
        </div>
    @endif
</div>
