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
                    provider Mollie. Using Mollie you can pay your outstanding balance using 
                        @foreach ($methods as $method)
                            @if ($loop->last)
                                {{ $method->description."." }}
                            @else
                                {{ $method->description.", " }}
                            @endif
                        @endforeach
                </p>
                @if($use_fees)
                    <p>
                        <strong>Important!</strong> Using this service you will incur a transaction fee on top
                        of your outstanding balance for some methods. This transaction will appear in your OmNomCom history after payment. 
                        Hover on a payment method's icon to see the transaction fee.
                    </p>
                @endif
                <p>
                    If you wish to pay only a part of your outstanding balance, please use the field below
                    to indicate the maximum amount you would like to pay.
                </p>
            </div>
            <form method="post" action="{{ route('omnomcom::mollie::pay') }}">
                {!! csrf_field() !!}
                @if ($use_fees)
                    <div class="modal-body text-left container">
                        Available payment methods
                        <div class="row justify-content-around btn-group-toggle mb-2" data-toggle="buttons">
                            @include('omnomcom.mollie.list-all-payment-methods')
                        </div>
                    </div>
                @endif
                    
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-6">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">&euro;</span>
                                </div>
                                <input type="text" class="form-control float-left" type="number" name="cap"
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
                </div>
            </form>
        </div>
    </div>
</div>