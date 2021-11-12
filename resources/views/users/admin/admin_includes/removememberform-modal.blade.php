<div class="modal fade" id="remove-member-form" tabindex="-1" role="dialog">
    <div class="modal-dialog model-sm" role="document">
        <form method="post" name="remove-member-form">
            {!! csrf_field() !!}
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Membership Form</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete the signed membership form of <i>{{ $user->name }}</i>?</p>
                    <p>Only delete a signed membership form if the form is invalid or the user does not want to become a member.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete Membership Form</button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('javascript')
    <script type="text/javascript" nonce="{{ csp_nonce() }}">
        document.getElementById('remove-member-form').addEventListener('show.bs.modal', e => {
            const id = e.relatedTarget.getAttribute('data-id')
            e.target.querySelector('form').setAttribute('action', "{{ route("memberform::delete", ['id' => ':id']) }}".replace(':id', id))
        })
    </script>
@endpush