<a
    href="#"
    class="confirm-modal-button {{ $classes ?? null }}"
    data-form="{{ $form ?? null }}"
    data-confirm-action="{{ $action ?? null }}"
    data-confirm-title="{{ $title ?? 'Confirm Action' }}"
    data-confirm-message="{{ $message ?? 'Are you sure?' }}"
    data-confirm-btn-text="{{ $confirm ?? $text }}"
    data-form-method="{{ $method ?? 'GET' }}"
    data-confirm-btn-variant="confirm-button btn {{ $confirmButtonVariant ?? 'btn-danger' }}"
    data-bs-toggle="modal"
    data-bs-target="#confirm-modal"
>
    {!! $text !!}
</a>

@once
    @push('modals')
        <div class="modal fade" id="confirm-modal" tabindex="-1" role="dialog">
            <div class="modal-dialog model-sm" role="document">
                <form method="POST">
                    <input
                        type="hidden"
                        name="_method"
                        id="confirm-form-method"
                        value=""
                    />
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Confirm</h5>
                            <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="modal"
                                aria-label="Close"
                            ></button>
                        </div>
                        <div class="modal-body">Are you sure?</div>
                        <div class="modal-footer">
                            <button
                                type="button"
                                class="btn btn-default"
                                data-bs-dismiss="modal"
                            >
                                Cancel
                            </button>
                            <button
                                id="submit-button"
                                type="submit"
                                class="confirm-button btn"
                            >
                                Confirm
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endpush
@endonce

@once
    @push('javascript')
        <script @cspNonce>
            window.addEventListener('load', () => {
                document
                    .querySelectorAll('.confirm-modal-button')
                    .forEach((el) => {
                        window.initConfirmButton(el)
                    })
            })
        </script>
    @endpush
@endonce
