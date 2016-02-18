<!-- Modal for adding automatic withdrawal. //-->
<form method="POST" action="{{ route('user::bank::add', ['id' => $user->id]) }}">
    {!! csrf_field() !!}
    <div id="bank-modal-add" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Authorize for automatic withdrawal</h4>
                </div>
                <div class="modal-body">
                    @if($user->id != Auth::id())

                        <p>
                            Sorry, but due to accountability issues you can only add authorizations for yourself.
                            If {{ $user->name }} really wants to pay via automatic withdrawal, they should configure
                            so
                            themselves.
                        </p>

                    @else

                        <div class="form-group">
                            <label for="iban">Account IBAN</label>
                            <input type="text" class="form-control" id="iban" name="iban"
                                   placeholder="NL42INGB0013371337">
                        </div>
                        <div class="form-group">
                            <label for="bic">Account BIC</label>
                            <input type="text" class="form-control" id="bic" name="bic" placeholder="INGBNL2A">
                        </div>

                        <p>

                            <strong>Important stuff</strong>

                        </p>
                        <p>

                            << Insert all kinds of important stuff. >>

                        </p>

                    @endif
                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-success"
                            @if($user->id != Auth::id())
                            disabled
                            @endif
                    >
                        I have read all the important stuff and agree with it.
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
