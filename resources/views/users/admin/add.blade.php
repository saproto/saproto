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
                                kindly ask the user to - if they are a student - link their UTwente account!
                            </strong>
                        </p>
                    @endif

                    @if (!$user->address)
                        <p style="color: red;">
                            <strong>
                                This user does not have an address linked to their account. Please ask them to register
                                an address before making them a member.
                            </strong>
                        </p>
                    @elseif ($user->bank()->count() == 0)
                        <p style="color: red;">
                            <strong>
                                This user does not have a current bank authorization. This is required for membership.
                                Please ask them to enter a bank authorization before making them a member.
                            </strong>
                        </p>
                    @endif

                    <p>You are about to make {{ $user->name }} a member.</p>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    @if ($user->address && $user->bank)
                        <button type="submit" class="btn btn-success"
                                onClick="return confirm('Did this user sign the membership form?')">Make member
                        </button>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>