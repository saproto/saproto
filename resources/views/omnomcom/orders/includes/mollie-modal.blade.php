<div id="mollie-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLongTitle">Pay outstanding balance</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-justify">
                <p>
                    Using this service you can pay your outstanding balance using our external payment
                    provider Mollie. Using Mollie you can pay your outstanding balance using iDeal,
                    CreditCard, Bitcoin and various German and Belgian payment providers.
                </p>
                <p>
                    <strong>Important!</strong> Using this service you will incur a transaction fee on top
                    of your outstanding balance. This transaction fee is
                    €{{ number_format(config('omnomcom.mollie')['fixed_fee'], 2) }} per transaction
                    plus {{ number_format(config('omnomcom.mollie')['variable_fee']*100, 2) }}% of the total
                    transaction. This transaction will appear in your OmNomCom history after payment.
                </p>
                <p>
                    If you wish to pay only a part of your outstanding balance, please use the field below
                    to indicate the maximum amount you would like to pay.
                </p>
            </div>
            <div class="modal-footer">
                <form method="post" action="{{ route('omnomcom::mollie::pay') }}">
                    {!! csrf_field() !!}
                    <div class="row">
                        <div class="col-6">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">&euro;</span>
                                </div>
                                <input class="form-control float-start" type="number" name="cap"
                                       value="{{ ceil($next_withdrawal) }}">
                                <div class="input-group-append">
                                    <span class="input-group-text">.00</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <button type="button" class="btn btn-default btn-block" data-dismiss="modal">
                                Close
                            </button>
                        </div>
                        <div class="col-3">
                            <button type="submit" class="btn btn-primary btn-block">Pay</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>