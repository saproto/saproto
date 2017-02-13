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

                    @if($user->utwente_username == null)
                        <p>
                            <strong>
                                This user has no University of Twente account linked to their user account. Please
                                kindly ask the user to - if he is a student - link their UTwente account!
                            </strong>
                        </p>
                    @endif

                    @if (!$user->address)
                        <p>
                            <strong>
                                This user does not have an address linked to their account. Please ask them to register
                                an address before making them a member.
                            </strong>
                        </p>
                    @elseif ($user->bank()->count() == 0)
                        <p>
                            <strong>
                                This user does not have a current bank authorization. This is required for membership.
                                Please ask them to enter a bank authorization before making them a member.
                            </strong>
                        </p>
                    @else

                        <p>
                            You are about to initiate membership for {{ $user->name }}. Please indicate below whether
                            the user should be a primary member of not.
                        </p>

                        <div class="form-group">
                            {{ csrf_field() }}
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="is_primary" checked>
                                    This member is currently studying CreaTe, or is a CreaTe graduate still studying at
                                    the UT.
                                </label>
                            </div>
                        </div>
                    @endif
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    @if ($user->address && $user->bank)
                        <button type="submit" class="btn btn-primary"
                                onClick="return confirm('Did this user sign the membership form?')">Make member
                        </button>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>