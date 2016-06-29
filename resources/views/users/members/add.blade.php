<div class="modal fade" id="addMembership" tabindex="-1" role="dialog" aria-labelledby="addMembershipLabel">
    <div class="modal-dialog" role="document">
        <form action="{{ route("user::member::add", ['id'=>$user->id]) }}" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="addMembershipLabel">Make member</h4>
                </div>
                <div class="modal-body">
                    <p>
                        You are about to initiate membership for {{ $user->name }}. Please indicate below whether the
                        user should be a primary member of not. Also, don't forget to print the lidmaatschapsformulier.
                    </p>

                    <div class="form-group">
                        {{ csrf_field() }}
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="is_primary" checked>
                                This member is currently studying CreaTe, or is a CreaTe graduate still studying at the
                                UT.
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Make member</button>
                </div>
            </div>
        </form>
    </div>
</div>