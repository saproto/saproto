<div class="card mb-3">

    <div class="card-header bg-dark text-white">
        Financial details
    </div>

    <div class="card-body">

        <p class="card-text">
            Total spent in {{ date('F Y', strtotime($selected_month)) }}
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

        @elseif($next_withdrawal < 0)

            <p class="card-text">
                OmNomCom credit left
            </p>

            <h3 class="card-title">
                &euro; {{ number_format(-$next_withdrawal, 2, '.', '') }}
            </h3>

        @endif

    </div>

    @if($next_withdrawal > 0)

        <div class="card-footer">
            <a href="javascript:void();" class="btn btn-primary btn-block" data-toggle="modal" data-target="#mollie-modal">
                Pay now
            </a>
        </div>

    @elseif($next_withdrawal < 0)

        <div class="card-footer">

            You won't be charged as long as you have OmNomCom credit.

        </div>

    @endif

</div>