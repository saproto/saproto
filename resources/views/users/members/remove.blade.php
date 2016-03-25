<div class="modal fade" id="removeMembership" tabindex="-1" role="dialog" aria-labelledby="removeMembershipLabel">
    <div class="modal-dialog" role="document">
        <form action="{{ route("user::member::remove", ['id'=>$user->id]) }}" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="removeMembershipLabel">End membership</h4>
                </div>
                <div class="modal-body">
                    Enter the end date for the membership of {{ $user->name }}:
                    <br /><br />
                    <div class="form-group">
                        {{ csrf_field() }}
                        <div class="row">
                            <label for="date" class="col-sm-3 control-label">End date</label>
                            <div class="col-sm-9">
                                <input type="date" class="form-control" id="date" name="date" placeholder="End Date">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">End membership</button>
                </div>
            </div>
        </form>
    </div>
</div>