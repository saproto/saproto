<div class="modal fade" id="removeMembership" tabindex="-1" role="dialog" aria-labelledby="removeMembershipLabel">
    <div class="modal-dialog model-sm" role="document">
        <form action="{{ route("user::member::remove", ['id'=>$user->id]) }}" method="post">
            {!! csrf_field() !!}
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="removeMembershipLabel">End membership</h4>
                </div>
                <div class="modal-body">
                    Are you sure you want to end the membership of {{ $user->name }}?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">End membership</button>
                </div>
            </div>
        </form>
    </div>
</div>