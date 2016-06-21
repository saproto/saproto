<div id="yubikey-modal" class="modal fade " tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">

            <form method="post" action="{{ route('user::2fa::addyubikey', ['user_id' => $user->id]) }}"
                  class="form-horizontal">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">YubiKey 2FA</h4>
                </div>

                <div class="modal-body">

                    <p style="text-align: center;">
                        Insert your YubiKey.<br>
                        If necessary, press the button on it.
                    </p>

                    {!! csrf_field() !!}

                    <p style="text-align: center;">
                        <input type="password" class="form-control" name="2facode" placeholder="Your YubiKey OTP."
                               autofocus>
                    </p>

                </div>

                <div class="modal-footer">
                    <input type="submit" class="btn btn-success" value="Save">
                    <button type="button" data-dismiss="modal" class="btn btn-default">Cancel</button>
                </div>

            </form>

        </div>
    </div>
</div>