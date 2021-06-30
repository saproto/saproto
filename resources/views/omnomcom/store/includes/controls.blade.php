<div id="controls" class="fixed-bottom bg-omnomcom align-content-center p-2 mb-4">

    <span id="purchase" class="btn btn-lg bg-dark float-right inactive">
        <i class="fas fa-cookie-bite mr-2"></i> Complete order
    </span>
    @if($store->cash_allowed)
        <span id="purchase-cash-initiate" class="btn btn-lg bg-dark mr-2 float-right inactive">
            <i class="fas fa-coins mr-2"></i> Complete with cash
        </span>
    @endif
    @if($store->bank_card_allowed)
        <span id="purchase-bank-card-initiate" class="btn btn-lg bg-dark mr-2 float-right inactive">
            <i class="fas fa-credit-card mr-2"></i> Complete with PIN
        </span>
    @endif
    <span id="rfid" class="btn btn-lg bg-dark mr-2 float-right">Link RFID card</span>
    <span class="info float-right font-weight-bold mr-3 my-auto">Order total: &euro;<span id="total">0.00</span></span>
    <span id="status" class="info float-right mr-3 inactive">RFID Service: Disconnected</span>

    <div id="cart"></div>

</div>