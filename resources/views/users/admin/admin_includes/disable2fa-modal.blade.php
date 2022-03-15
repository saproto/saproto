<div class="modal fade" id="disable2FA" tabindex="-1" role="dialog" aria-labelledby="disable2FALabel">
    <div class="modal-dialog model-sm" role="document">
        <form action="{{ route("user::2fa::admindelete", ['id'=>$user->id]) }}" method="post">
            {!! csrf_field() !!}
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Disable Two-Factor Authentication</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to disable the two-factor authentication of {{ $user->name }}?
                    <b>Only continue if you have their consent!</b>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Disable 2FA</button>
                </div>
            </div>
        </form>
    </div>
</div>