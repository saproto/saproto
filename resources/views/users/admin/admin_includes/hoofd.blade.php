<div class="card mb-3">
    <div class="card-header bg-dark text-white">
        {{ $user->calling_name }}'s hoofd
    </div>

    <div class="card-body p-5 text-center">
        <img
            src="{{ $user->getFirstMediaUrl('profile_picture', 'preview') }}"
            class="rounded-circle mw-100"
        />
    </div>
</div>
