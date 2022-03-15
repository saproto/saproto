<div class="card mb-3">

    <div class="card-header bg-dark text-white">
        Recent withdrawals
    </div>

    @if(count($user->withdrawals(1)) > 0)

        <ul class="list-group list-group-flush">

            @foreach($user->withdrawals(6) as $withdrawal)
                <li class="list-group-item">
                    <a href="{{ route('omnomcom::mywithdrawal', ['id' => $withdrawal->id]) }}">
                        {{ date('d-m-Y', strtotime($withdrawal->date)) }}
                    </a>
                    @if($withdrawal->getFailedWithdrawal($user))
                        <i class="fas fa-times text-danger ml-2"></i>
                    @endif
                    <span class="float-right">
                                &euro;{{ number_format($withdrawal->totalForUser($user), 2, '.', ',') }}
                            </span>
                </li>
            @endforeach

        </ul>

    @else

        <div class="card-body">

            <p class="card-text text-center">

                None available yet.

            </p>

        </div>

    @endif

</div>

@if(count($user->mollieTransactions) > 0)

    <div class="card mb-3">

        <div class="card-header bg-dark text-white">
            Recent payments
        </div>

        <ul class="list-group list-group-flush">

            @foreach($user->mollieTransactions->sortByDesc(['created_at']) as $transaction)
                <li class="list-group-item">
                    <a href="{{ route('omnomcom::mollie::status', ['id' => $transaction->id]) }}">
                        {{ date('d-m-Y H:i', strtotime($transaction->created_at)) }}
                        {!! Proto\Models\MollieTransaction::translateStatus($transaction->translatedStatus()) == "open" ? '<i class="fas fa-spinner ml-2 text-normal"></i>' : "" !!}
                        {!! Proto\Models\MollieTransaction::translateStatus($transaction->translatedStatus()) == "failed" ? '<i class="fas fa-times ml-2 text-danger"></i>' : "" !!}
                        {!! Proto\Models\MollieTransaction::translateStatus($transaction->translatedStatus()) == "paid" ? '<i class="fas fa-check ml-2 text-success"></i>' : "" !!}
                        {!! Proto\Models\MollieTransaction::translateStatus($transaction->translatedStatus()) == "unknown" ? '<i class="fas fa-question ml-2 text-normal"></i>' : "" !!}
                    </a>
                    <span class="float-right">&euro;{{ number_format($transaction->amount, 2, '.', ',') }}</span>
                </li>
            @endforeach

        </ul>

    </div>

@endif
