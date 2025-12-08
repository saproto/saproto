@php
    use App\Models\User;
@endphp

@foreach ($participants as $user)
    <?php $pid =
    $user::class == User::class && $event ? $user->pivot->id : $user->id; ?>

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
            <a
                class="btn btn-outline-warning participation-admin-modal-button"
                title="Manage participation"
                href="#"
                data-bs-toggle="modal"
                data-bs-target="#participation-admin-modal"
                data-participation="{{ $pid }}"
                data-user-name="{{ $u->name }}"
                data-user="{{ $u->id }}"
                >
                <i class="fas fa-pencil" aria-hidden="true"></i>
            </a>
        @endif
    </div>
@endforeach


@once
    @push('modals')
        <div class="modal" id="participation-admin-modal" tabindex="-1" role="dialog">
            <div class="modal-dialog model-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Manage Participation for ...</h5>
                        <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="modal"
                                aria-label="Close"
                            ></button>

                    </div>
                    <div class="modal-body">
                        <div class="d-flex flex-column">
                            <label class="mb-1"for="pam-unparticipate"><b>Remove this user from the participant list</b></label>
                            <a
                                href="#"                             class="btn btn-outline-warning"
                                id="pam-unparticipate"
                                <i class="fas fa-times" aria-hidden="true"></i> Remove
                            </a>
                        </div>
                        <div class="d-flex flex-column">
                            <form method="POST" action="{{route('event:swap_participation')}}">
                                {{ csrf_field() }}
                                <input id="pam-swap-from" name="from" class="d-none" type="number", value="0"/>
                                <input id="pam-swap-pid" name="pid" class="d-none" type="number", value="0"/>
                                <label class="mb-1"for="pam-unparticipate"><b>Swap this user with another user</b></label>
                                <div class="row mb-3">
                                    <div class="col-9">
                                    <div class="form-group autocomplete ">
                                        <input class="form-control user-search" name="to" required />
                                    </div>
                                    </div >
                                    <div class="col-3">
                                        <button
                                        class="btn btn-outline-primary btn-block"
                                        type="submit"
                                        >
                                            <i class="fas fa-arrow-right-arrow-left"></i>
                                        </button>

                                    </div >
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">

                    </div>
                </div>
            </div>
        </div>
    @endpush
@endonce

@once
    @push('javascript')
        <script nonce="{{ csp_nonce() }}">
           document.querySelectorAll('.participation-admin-modal-button').forEach((el) => el.addEventListener('click',(e) => {
                const modal = document.querySelector(
                    el.getAttribute('data-bs-target')
                );
                const pid = el.getAttribute('data-participation');
                const uid = el.getAttribute('data-user');
                const username = el.getAttribute('data-user-name');

                modal.querySelector('.modal-title').innerHTML = "Manage participation for " +  username + ".";

                modal.querySelector('#pam-unparticipate').href = "{{ route('event::deleteparticipation', ['participation' => '_pid_']) }}".replace('_pid_', pid)

                modal.querySelector('#pam-swap-from').value = uid;
                modal.querySelector('#pam-swap-pid').value = pid;

            } ));
        </script>
    @endpush
@endonce
