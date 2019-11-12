<div id="totp-modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">

            <form method="post" action="{{ route('user::2fa::addtimebased') }}"
                  class="form-horizontal">

                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Time Based Two-Factor Authentication</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <p style="text-align: center;">
                        Scan the code below with your 2FA app and enter your code below to verify.
                    </p>

                    {!! csrf_field() !!}

                    <p style="text-align: center;">
                        <img src="{{ $tfa_qrcode }}">
                    </p>

                    <p style="text-align: center; padding: 0 150px;">
                        <input class="form-control" name="2facode" placeholder="Your six digit code.">
                        <input type="hidden" name="2fakey" value="{{ $tfa_key }}">
                    </p>

                    <p style="text-align: center;">
                        You can also enter the below secret key manually.<br>
                        <strong>{{ $tfa_key }}</strong>
                    </p>

                </div>

                <div class="modal-footer">
                    <input type="submit" class="btn btn-success" value="Save">
                    <a data-dismiss="modal" class="btn btn-default">Cancel</a>
                </div>

            </form>

        </div>
    </div>
</div>

<div id="totp-modal-disable" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">

            <form method="post" action="{{ route('user::2fa::deletetimebased') }}"
                  class="form-horizontal">

                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Disable Time Based Two-Factor Authentication</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <p style="text-align: center;">
                        Enter a valid 2FA code from your app to disable 2FA.
                    </p>

                    {!! csrf_field() !!}

                    <p style="text-align: center; padding: 0 150px;">
                        <input class="form-control" name="2facode" placeholder="Your six digit code.">
                    </p>

                </div>

                <div class="modal-footer">
                    <input type="submit" class="btn btn-success" value="Disable two-factor authentication">
                    <a data-dismiss="modal" class="btn btn-default">Cancel</a>
                </div>

            </form>

        </div>
    </div>
</div>