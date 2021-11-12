<div id="controls" class="fixed-bottom bg-omnomcom align-content-center p-2 mb-4">

    <span id="purchase" class="btn btn-lg bg-dark float-end inactive">
        <i class="fas fa-cookie-bite me-2"></i> Complete order
    </span>
    @if($store->cash_allowed)
        <span id="purchase-cash-initiate" class="btn btn-lg bg-dark me-2 float-end inactive">
            <i class="fas fa-coins me-2"></i> Complete with cash
        </span>
    @endif
    @if($store->bank_card_allowed)
        <span id="purchase-bank-card-initiate" class="btn btn-lg bg-dark me-2 float-end inactive">
            <i class="fas fa-credit-card me-2"></i> Complete with PIN
        </span>
    @endif
    <span id="rfid" class="btn btn-lg bg-dark me-2 float-end">Link RFID card</span>
    <span class="info float-end font-weight-bold me-3 my-auto">Order total: &euro;<span id="total">0.00</span></span>
    <span id="status" class="info float-end me-3 inactive">RFID Service: Disconnected</span>

    <div id="cart"></div>

</div>