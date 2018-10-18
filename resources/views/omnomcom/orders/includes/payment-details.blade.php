<div class="card">

    <div class="card-header">
        Payment details
    </div>

    <div class="card-body">

        <p class="card-text">
            Total for {{ date('F Y', strtotime($selected_month)) }}
        </p>

        <h3 class="card-title">
            &euro; {{ number_format($total, 2, '.', '') }}
        </h3>

        @if($next_withdrawal > 0)

            <p class="card-text">
                Next withdrawal
            </p>

            <h3 class="card-title">
                &euro; {{ number_format($next_withdrawal, 2, '.', '') }}
            </h3>

        @endif

    </div>

    @if($next_withdrawal)

        <div class="card-footer">

            <button class="btn btn-primary btn-block" type="button" data-toggle="modal"
                    data-target="#mollie-modal">
                Pay next withdrawal now
            </button>

        </div>

    @endif

</div>