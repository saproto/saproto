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

        @if($outstandingAmount>0)
            <p class="card-text">
                Remaining outstanding
                <i class="fas fa-info-circle" data-bs-toggle="tooltip" data-bs-placement="right" title="The amount caught up in activities you signed up for that still have to be processed. This will not be in the next withdrawal but you will have to pay this this money somewhere in the future."></i>
            </p>
            <ul class="list-group list-group-flush" id="outstanding-accordion">

                    <li class="cursor-pointer" data-bs-toggle="collapse"
                        data-bs-target="#outstanding">
                        <h3 class="card-title">
                            &euro; {{ number_format($outstandingAmount, 2, '.', '') }}
                        </h3>
                    </li>
                    <div id="outstanding" class="collapse" data-parent="#outstanding-accordion">
                        <table class="table table-borderless table-hover table-sm mt-1">
                            <thead>
                            <tr>
                                <th scope="col">Activity</th>
                                <th scope="col">Amount</th>
                            </tr>
                            </thead>
                            <tbody
                                @foreach($outstanding as $outstandingActivity)
                                    <tr>
                                        <td>{{ $outstandingActivity->event->title }}</td>
                                        <td>&euro; {{ number_format($outstandingActivity->price, 2, '.', '') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
            </ul>
        @endif
    </div>
    
    @if($next_withdrawal > 0)

        <div class="card-footer">
            <a href="#" class="btn btn-primary btn-block" data-bs-toggle="modal" data-bs-target="#mollie-modal">
                Pay now
            </a>
        </div>

    @elseif($next_withdrawal < 0)

        <div class="card-footer">

            You won't be charged as long as you have OmNomCom credit.

        </div>

    @endif

</div>