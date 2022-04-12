<div class="modal fade" id="setMembershipType" tabindex="-1" role="dialog" aria-labelledby="setMembershipTypeLabel">
    <div class="modal-dialog model-sm" role="document">
        <form action="{{ route("user::member::settype", ['id'=>$user->id]) }}" method="post">
            {!! csrf_field() !!}
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Set membership type</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to change the membership type of {{ $user->name }}?</p>
                    <span class="mr-1">Membership type:</span>
                        <select class="form-select px-2 py-1" aria-label="Membership types" name="type">
                        <option>Regular member</option>
                        <option {{ $user->member->is_honorary ? 'selected' : '' }} value="honorary">Honorary member</option>
                        <option {{ $user->member->is_lifelong ? 'selected' : '' }} value="lifelong">Lifelong member</option>
                        <option {{ $user->member->is_donor ? 'selected' : '' }} value="donor">Donor</option>
                        <option {{ $user->member->is_pet ? 'selected' : '' }} value="pet">Pet member</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Set membership type</button>
                </div>
            </div>
        </form>
    </div>
</div>