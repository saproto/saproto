<div class="modal fade" id="removeMemberForm" tabindex="-1" role="dialog" aria-labelledby="removeMemberFormLabel">
    <div class="modal-dialog model-sm" role="document">
        <form action="{{ route("memberform::delete", ['id'=>$user->id]) }}" method="post">
            {!! csrf_field() !!}
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Membership Form</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete the signed membership form of <i>{{ $user->name }}</i>?</p>
                    <p>Only delete a signed membership form if the form is invalid or the user does not want to become a member.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete Membership Form</button>
                </div>
            </div>
        </form>
    </div>
</div>