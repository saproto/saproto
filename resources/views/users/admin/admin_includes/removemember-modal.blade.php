<div class="modal fade" id="removeMembership" tabindex="-1" role="dialog" aria-labelledby="removeMembershipLabel">
    <div class="modal-dialog model-sm" role="document">
        <form action="{{ route("user::member::remove", ['id'=>$user->id]) }}" method="post">
            {!! csrf_field() !!}
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">End membership</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to end the membership of {{ $user->name }}?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">End membership</button>
                </div>
            </div>
        </form>
    </div>
</div>