<div class="card mb-3">

    <div class="card-header bg-dark text-white">
        Financial details
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

            <a href="javascript:void();" class="btn btn-primary btn-block" data-toggle="modal"
                    data-target="#mollie-modal">
                Pay now
            </a>

        </div>

    @endif

</div>