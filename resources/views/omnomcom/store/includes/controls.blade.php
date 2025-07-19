@php
    use Illuminate\Support\Facades\Vite;
@endphp

<div
    id="controls"
    class="fixed-bottom bg-omnomcom align-content-center mb-4 p-2"
>
    <button
        id="purchase"
        class="purchase-button btn btn-lg bg-dark float-end"
        disabled
    >
        <i class="fas fa-cookie-bite me-2"></i>
        Complete order
    </button>
    @if ($store['cash_allowed'])
        <button
            id="purchase-cash-initiate"
            class="purchase-button btn btn-lg bg-dark float-end me-2"
            disabled
        >
            <i class="fas fa-coins me-2"></i>
            Complete with cash
        </button>
    @endif

    @if ($store['bank_card_allowed'])
        <button
            id="purchase-bank-card-initiate"
            class="purchase-button btn btn-lg bg-dark float-end me-2"
            disabled
        >
            <i class="fas fa-credit-card me-2"></i>
            Complete with PIN
        </button>
    @endif

    <span id="rfid" class="btn btn-lg bg-dark float-end me-2">
        Link RFID card
    </span>
    <span class="info font-weight-bold float-end my-auto me-3">
        Order total: &euro;
        <span id="total">0.00</span>
    </span>
    <span id="status" class="info inactive float-end me-3">
        RFID Service: Disconnected
    </span>

    <div id="cart">
        <div id="cart-overflow" class="stretched-link bg-white">
            <div class="cart-product-image">
                <div
                    class="cart-product-image-inner"
                    style="
                        background-image: url({{ Vite::asset('resources/assets/images/font-awesome/fa-cart-shopping.svg') }});
                    "
                ></div>
            </div>
            <div class="cart-product-count">0x</div>
        </div>
    </div>
</div>
