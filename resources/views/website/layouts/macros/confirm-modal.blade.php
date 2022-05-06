<a href="#"
   class="confirm-modal-button {{ $classes ?? '' }}"
   data-confirm-action="{{ $action }}"
   data-confirm-method="{{ $method ?? 'GET' }}"
   data-confirm-title="{{ $title ?? 'Confirm Action' }}"
   data-confirm-message="{{ $message ?? 'Are you sure?' }}"
   data-confirm-btn-text="{{ $confirm ?? $text }}"
   data-bs-toggle="modal"
   data-bs-target="#confirm-modal">
    {!! $text !!}
</a>

@once
    @push('modals')
        <div class="modal fade" id="confirm-modal" tabindex="-1" role="dialog">
            <div class="modal-dialog model-sm" role="document">
                <form>
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Confirm</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">Are you sure?</div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="confirm-button btn btn-danger">Confirm</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endpush
@endonce

@once
    @push('javascript')
        <script nonce="{{ csp_nonce() }}">
            document.querySelectorAll('.confirm-modal-button').forEach(el => el.addEventListener('click', e => {
                const modal = document.querySelector(el.getAttribute('data-bs-target'))
                modal.querySelector('.modal-title').innerHTML = el.getAttribute('data-confirm-title')
                modal.querySelector('.modal-body').innerHTML = el.getAttribute('data-confirm-message')
                modal.querySelector('.confirm-button').innerHTML = el.getAttribute('data-confirm-btn-text')
                modal.querySelector('form').action = el.getAttribute('data-confirm-action')
                modal.querySelector('form').method = el.getAttribute('data-confirm-method')
            }))
        </script>
    @endpush
@endonce