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
                    @if($withdrawal->getFailedWithdrawal($user) || $withdrawal->id == 'temp')
                        <i class="fas fa-times text-danger ms-2"></i>
                    @endif
                    <span class="float-end">
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
                    @if($transaction->mollie_id != 'temp')
                        @php
                            $status = Proto\Models\MollieTransaction::translateStatus($transaction->translatedStatus())
                        @endphp
                        <a href="{{ route('omnomcom::mollie::status', ['id' => $transaction->id]) }}">
                            {{ date('d-m-Y H:i', strtotime($transaction->created_at)) }}
                            <i class="fas ms-2
                                {{ $status == "open" ? ' fa-spinner text-normal' : '' }}
                                {{ $status == "failed" ? 'fa-times text-danger' : '' }}
                                {{ $status == "paid" ? 'fa-check text-success' : '' }}
                                {{ $status == "unknown" ? 'fa-question text-normal' : '' }}
                            "></i>
                        </a>
                    @else
                        <span>This payment is corrupt, please contact board</span>
                    @endif
                    <span class="float-right">&euro;{{ number_format($transaction->amount, 2, '.', ',') }}</span>
                </li>
            @endforeach

        </ul>

    </div>

@endif
