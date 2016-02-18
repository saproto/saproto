<!-- Modal for deleting automatic withdrawal. //-->
<div id="bank-modal-cancel" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Cancel withdrawal authorization</h4>
            </div>
            <div class="modal-body">
                @if($user->member != null)

                    <p>
                        Members cannot delete their authorization, because their membership fee will be withdrawn
                        using this authorization. If you are a member and wish to delete your authorization, you
                        first need to cancel your membership.
                    </p>

                @else

                    <p>
                        This action will cancel your current automatic withdrawal authorization. Everything bought
                        up until now will still be withdrawn from this bank account, but no more purchases can be
                        made using this authorization.
                    </p>

                    <p>
                        After all outstanding balance with this authorization has been paid, the authorization will
                        be permanently deleted. If you wish to make purchases in the future, you can always add a
                        new authorization.
                    </p>

                @endif
            </div>
            <div class="modal-footer">
                <form method="POST" action="{{ route('user::bank::delete', ['id' => $user->id]) }}">
                    {!! csrf_field() !!}
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        Keep my authorization active
                    </button>
                    <button type="submit" class="btn btn-danger"
                            @if($user->member != null)
                            disabled
                            @endif
                    >
                        Cancel my authorization
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>