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
                        <strong>
                            Deleting your authorization means you won't be able to attend activities, buy stuff and
                            otherwise do anything that costs money. You can always add a new authorization.
                        </strong>
                    </p>

                @endif

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

            </div>
            <div class="modal-footer">
                <form method="POST" action="{{ route('user::bank::delete', ['id' => $user->id]) }}">
                    {!! csrf_field() !!}
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        Keep my authorization active
                    </button>
                    <button type="submit" class="btn btn-danger">
                        Cancel my authorization
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>